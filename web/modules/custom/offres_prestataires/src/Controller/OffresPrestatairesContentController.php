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
            $offers = $this->offreRepository->findAllActive();
            foreach ($offers as $k => $offer) {
                $offers[$k] = $this->formatDataForFront($offer);
            }

            $build = [
                '#theme' => 'offres_prestataires--list',
                '#data' => $offers
            ];
        } else {
            $build['#theme'] = "offres_prestataires--content";

            $offre = $this->offreRepository->findBy(['id_scoptalent' => $ref, 'active' => 1]);
            if (empty($offre)) {
                $build['#data'] = 'false';
            } else {
                //if there's no record in log => increment offer view
                if (!$this->loggerFileHelper->searchInCSV($ref)) {
                    $this->loggerFileHelper->logIpAddressOnFile($ref);
                    $this->offreRepository->updateNbVue($ref);
                }
                $build = [
                    '#theme' => 'offres_prestataires--content',
                    '#data' => $this->formatDataForFront($offre[0])
                ];
            }
        }

        return $build;
    }

    private function formatDataForFront($offer)
    {
        if (isset($offer->contract_types)) $offer->contract_types = implode(', ', unserialize($offer->contract_types));
        if (isset($offer->domains)) $offer->domains = implode(', ', unserialize($offer->domains));
        return $offer;
    }
}