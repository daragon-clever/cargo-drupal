<?php
declare(strict_types=1);

namespace Drupal\offres_prestataires\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\offres_prestataires\Helper\LoggerFileHelper;
use Drupal\offres_prestataires\OffrePrestataireRepository;
use Symfony\Component\DependencyInjection\ContainerInterface;

class OffresPrestatairesContentController extends ControllerBase
{
    const TERRAIN_OFFERS = [
        "CDD - Contrat à durée déterminée",
        "CDI - Contrat à durée indéterminée",
        "CIDD - Contrat d'intervention à durée déterminée",
        "CTT - Contrat de travail temporaire"
    ];
    const PRESTA_OFFERS = [
        "Contrat de portage salarial",
        "Indépendants/freelances"
    ];

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

    public function content($ref, $type): array
    {
        $build['#type'] = $type;

        if ($ref == "all") {
            $build['#theme'] = 'offres_prestataires--list';

            if ($type == "presta") {
                $prestaFilter = ['contract_types' => self::PRESTA_OFFERS];
                $prestaFilter['active'] = 1;
                $offers = $this->offreRepository->findByMany($prestaFilter);
                foreach ($offers as $k => $offer) {
                    $offers[$k] = $this->formatDataForFront($offer);
                }
                $build['#data'] = $offers;
            } elseif ($type == "terrain") {
                $terrainFilter = ['contract_types' => self::TERRAIN_OFFERS];
                $terrainFilter['active'] = 1;
                $offers = $this->offreRepository->findByMany($terrainFilter);
                foreach ($offers as $k => $offer) {
                    $offers[$k] = $this->formatDataForFront($offer);
                }
                $build['#data'] = $offers;
            }
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
                $build['#data'] = $this->formatDataForFront($offre[0]);
            }
        }

        return $build;
    }

    private function formatDataForFront($offer)
    {
        if (isset($offer->domains)) $offer->domains = implode(', ', unserialize($offer->domains));
        return $offer;
    }
}