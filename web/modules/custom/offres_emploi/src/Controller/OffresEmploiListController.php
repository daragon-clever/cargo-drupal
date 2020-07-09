<?php
declare(strict_types=1);

namespace Drupal\offres_emploi\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\offres_emploi\Helper\LoggerFileHelper;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\offres_emploi\Helper\OffreEmploiHelperTrait;
use Drupal\offres_emploi\OffreEmploiRepository;

/**
 * Defines OffresEmploiListController class.
 */
class OffresEmploiListController extends ControllerBase
{

    private $actualTime;
    private $ipAddress;
    private $fileLogIPAnnonce;


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


    public function __construct(OffreEmploiRepository $offreRepository, LoggerFileHelper $loggerFileHelper)
    {
        $this->offreRepository = $offreRepository;
        $this->loggerFileHelper = $loggerFileHelper;
    }


    public function show($ref)
    {
        if ($ref == "all") {
            $build = [
                '#theme' => 'offres_emploi--list',
                '#data' => $this->offreRepository->findAllActive()
            ];
        } else {
            $offre = $this->offreRepository->findBy(['codeRecrutement' => $ref, 'active' => 1]);

            if (empty($offre)) {
                $build = [
                    '#theme' => 'offres_emploi--annonce',
                    '#data' => 'false'
                ];
            } else {
                //if there's no record in log => increment offer view
                if (!$this->loggerFileHelper->searchInCSV($ref)) {
                    $this->loggerFileHelper->logIpAddressOnFile($ref);
                    $this->offreRepository->updateNbVue($ref);
                }
                $build = [
                    '#theme' => 'offres_emploi--annonce',
                    '#data' => $offre[0]
                ];
            }
        }

        return $build;
    }
}