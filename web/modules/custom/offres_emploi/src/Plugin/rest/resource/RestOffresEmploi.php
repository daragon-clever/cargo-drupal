<?php
declare(strict_types=1);

namespace Drupal\offres_emploi\Plugin\rest\resource;

use Drupal\Core\Session\AccountProxyInterface;
use Drupal\offres_emploi\OffreEmploiRepository;
use Drupal\rest\Annotation\RestResource;
use Drupal\rest\Plugin\ResourceBase;
use Drupal\rest\ResourceResponse;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Drupal\offres_emploi\Helper\OffreEmploiHelperTrait;

/**
 * @RestResource(
 *     id = "offres_emploi_rest_endpoint_get",
 *     label = @Translation("Get List of job offers for CARGO"),
 *     uri_paths= {
 *          "canonical" = "/api/v1/offres-emploi"
 *     }
 * )
 *
 */
class RestOffresEmploi extends ResourceBase
{

    use OffreEmploiHelperTrait;

    /**
     * @var AccountProxyInterface
     */
    private $currentUser;
    /**
     * @var Request
     */
    private $currentRequest;
    /**
     * @var OffreEmploiRepository
     */
    private $repository;

    public function __construct(
        array $configuration,
        $plugin_id,
        $plugin_definition,
        array $serializer_formats,
        LoggerInterface $logger,
        AccountProxyInterface $currentUser,
        Request $currentRequest,
        OffreEmploiRepository $repository
    )
    {
        parent::__construct($configuration, $plugin_id, $plugin_definition, $serializer_formats, $logger);
        $this->currentUser = $currentUser;
        $this->currentRequest = $currentRequest;
        $this->repository = $repository;
    }

    /**
     * {@inheritdoc}
     */
    public static function create(ContainerInterface $container, array $configuration, $pluginId, $pluginDefinition) {
        return new static(
            $configuration,
            $pluginId,
            $pluginDefinition,
            $container->getParameter('serializer.formats'),
            $container->get('logger.factory')->get('rest'),
            $container->get('current_user'),
            $container->get('request_stack')->getCurrentRequest(),
            $container->get('offres_emploi.repository')
        );
    }

    /**
     * Responds to entity GET requests.
     * @return ResourceResponse
     */
    public function get(): ResourceResponse
    {
        if (!$this->currentUser->hasPermission('use ' . $this->pluginId . ' service')) {
            $this->logger->error( $this->currentUser->getAccountName() . ' : Access denied for this user to the Api');
            throw new AccessDeniedHttpException('Access denied for this user.');
        }

        $nameSite = $this->currentRequest->get('name');

        if ($nameSite) {
            $result = $this->repository->findBy(['filialeSociete' => self::$nameCompany[$nameSite]]);
        } else {
            $result = $this->repository->queryFindAllRessources()->fetchAll();
        }

        if (empty($result)) {
            $data = ['data' => 'no resources found'];
        } else {
            $dataSerialized = array_map(function($item) {
                return json_decode(json_encode($item), true);
            }, $result);
            $data = [
                'count' => count($result),
                'data' => $dataSerialized
            ];
        }
        return (new ResourceResponse($data))->addCacheableDependency($data);
    }
}