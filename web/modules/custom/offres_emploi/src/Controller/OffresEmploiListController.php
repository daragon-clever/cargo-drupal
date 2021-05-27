<?php
declare(strict_types=1);

namespace Drupal\offres_emploi\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\offres_emploi\Helper\LoggerFileHelper;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\offres_emploi\Helper\OffreEmploiHelperTrait;
use Drupal\offres_emploi\OffreEmploiRepository;

class OffresEmploiListController extends ControllerBase
{

    /**
     * @var OffreEmploiRepository
     */
    private $offreRepository;

    /**
     * @var LoggerFileHelper
     */
    private $loggerFileHelper;

    use OffreEmploiHelperTrait;

    /**
     * {@inheritdoc}
     */
    public static function create(ContainerInterface $container) {
        return new static(
            $container->get('offres_emploi.repository'),
            $container->get('offres_emploi.logger')
        );
    }

    public function __construct(
        OffreEmploiRepository $offreRepository,
        LoggerFileHelper $loggerFileHelper
    )
    {
        $this->offreRepository = $offreRepository;
        $this->loggerFileHelper = $loggerFileHelper;
    }

    /**
     * @param $ref
     * @return array|string[]
     */
    public function show($ref): array
    {
        if ($ref == "all") {
            $build = [
                '#theme' => 'offres_emploi--list',
                '#offers' => $this->offreRepository->findAllActive(),
            ];
        } else {
            $offre = $this->offreRepository->findBy(['codeRecrutement' => $ref, 'active' => 1]);

            if (empty($offre)) {
                $build = [
                    '#theme' => 'offres_emploi--annonce',
                    '#offer' => 'false'
                ];
            } else {
                //if there's no record in log => increment offer view
                if (!$this->loggerFileHelper->searchInCSV($ref)) {
                    $this->loggerFileHelper->logIpAddressOnFile($ref);
                    $this->offreRepository->updateNbVue($ref);
                }
                $build = [
                    '#theme' => 'offres_emploi--annonce',
                    '#offer' => (array)$offre[0]
                ];
            }
        }

        return $build;
    }
}
