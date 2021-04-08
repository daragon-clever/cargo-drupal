<?php
declare(strict_types=1);

namespace Drupal\offres_prestataires\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\offres_prestataires\Helper\LoggerFileHelper;
use Drupal\offres_prestataires\OffrePrestataireRepository;
use Symfony\Component\DependencyInjection\ContainerInterface;

class OffresPrestatairesContentController extends ControllerBase
{
    /**
     * @var OffrePrestataireRepository
     */
    private $offreRepository;

    /**
     * @var LoggerFileHelper
     */
    private $loggerFileHelper;

    public static function create(ContainerInterface $container) {
        return new static(
            $container->get('offres_prestataires.repository'),
            $container->get('offres_prestataires.logger')
        );
    }

    public function __construct(
        OffrePrestataireRepository $offrePrestataireRepository,
        LoggerFileHelper $loggerFileHelper
    )
    {
        $this->offreRepository = $offrePrestataireRepository;
        $this->loggerFileHelper = $loggerFileHelper;
    }

    public function content($ref): array
    {
        if ($ref == "all") {
            $build = [
                '#theme' => 'offres_prestataires--list',
                '#data' => $this->offreRepository->findAllActive()
            ];
        } else {
            $build['#theme'] = "offres_prestataires--content";

//            $offre = $this->offreRepository->findBy(['codeRecrutement' => $ref, 'active' => 1]);
//
//            if (empty($offre)) {
//                $build = [
//                    '#theme' => 'offres_emploi--annonce',
//                    '#data' => 'false'
//                ];
//            } else {
                //if there's no record in log => increment offer view
//                if (!$this->loggerFileHelper->searchInCSV($ref)) {
//                    $this->loggerFileHelper->logIpAddressOnFile($ref);
//                    $this->offreRepository->updateNbVue($ref);
//                }
//                $build = [
//                    '#theme' => 'offres_emploi--annonce',
//                    '#data' => $offre[0]
//                ];
//            }
        }

        return $build;
    }
}