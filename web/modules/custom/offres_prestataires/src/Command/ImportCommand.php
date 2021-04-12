<?php
declare(strict_types=1);

namespace Drupal\offres_prestataires\Command;

use Drupal\offres_prestataires\Helper\Request;
use Drupal\offres_prestataires\OffrePrestataireRepository;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Drupal\Console\Core\Command\Command;

/**
 * Class ImportCommand.
 *
 * Drupal\Console\Annotations\DrupalCommand (
 *     extension="offres_prestataires",
 *     extensionType="module"
 * )
 */
class ImportCommand extends Command
{
    /**
     * Name of the Console Command
     */
    private const COMMAND_NAME = 'offres_prestataires:import';

    /**
     * @var Request
     */
    private $requestHelper;

    /**
     * @var OffrePrestataireRepository
     */
    private $offreRepository;

    public function __construct(OffrePrestataireRepository $offreRepository)
    {
        parent::__construct();

        $this->offreRepository = $offreRepository;

        $this->requestHelper = new Request();
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName(self::COMMAND_NAME)
            ->setDescription('Importing Offres Prestataires')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        \Drupal::logger('offres_prestataires')->notice('[OFFRES PRESTATAIRES] Lancement import');
        $this->getIo()->info('[OFFRES PRESTATAIRES] Lancement import');

        //launch the import
        $this->import();

        drupal_flush_all_caches();

        $this->getIo()->info('[OFFRES PRESTATAIRES] import terminé');
        \Drupal::logger('offres_prestataires')->notice('[OFFRES PRESTATAIRES] import terminé');
    }

    /**
     * Execute the Import from the Scoptalent API
     */
    private function import()
    {
        $offerList = $this->getAllOffers();
        foreach ($offerList as $offer) {
            $currentOffer = $this->getOffer($offer['id']);

            $dataHydrated = $this->hydrateData($currentOffer);
            $dataHydrated['active'] = 1;

            $allRefsActive[] = $dataHydrated['id_scoptalent'];

            $offreExist = $this->offreRepository->findBy(['id_scoptalent' => $dataHydrated['id_scoptalent']]);

            if ($offreExist) {
                $this->getIo()->info('[OFFRES PRESTATAIRES] Starting Updating Offer with id_scoptalent: ' . current($offreExist)->id_scoptalent);
                $this->offreRepository->update($dataHydrated);
            } else {
                $this->getIo()->info('[OFFRES PRESTATAIRES] Starting Creating Offer with id_scoptalent: ' . $dataHydrated['id_scoptalent']);
                $this->offreRepository->insert($dataHydrated);
            }
        }

        $this->disableAllOffresNotIn($allRefsActive);

        return $this->getIo()->info('[OFFRES PRESTATAIRES] importing offers done with success !');
    }

    /**
     * Call API to get all offers
     * @return array
     */
    private function getAllOffers()
    {
        $pageNumber = 1;
        $urlParams['pageSize'] = 5;

        $offers = [];
        for ($currentPage = 1; $currentPage <= $pageNumber; $currentPage++) {
            $urlParams['pageNumber'] = $currentPage;

            $reqResp = $this->requestHelper->getVacanciesList($urlParams);

            //Calculate total number of pages on first request call
            if ($currentPage === 1) {
                $pageNumber = ceil($reqResp['totalQueryCount'] / $urlParams['pageSize']);
            }

            $offers = array_merge($offers, $reqResp['data']);
        }

        return $offers;
    }

    /**
     * Call API to get all infos of the offer
     * @param $id
     * @return array|null
     */
    private function getOffer($id)
    {
        return $this->requestHelper->getVacancyDetails($id);
    }

    /**
     * Hydrate Data
     * @param $offre
     * @return array
     */
    private function hydrateData($offre): array
    {
        $arrDB = ["id_scoptalent", "title", "mission_desc", "business_desc", "profile_desc",
            "created_date", "last_update_scoptalent", "reference", "city", "contract_types",
            "domains", "jobs_number"];
        $arrAPI = ["id", "title", "missionDescription", "businessDescription", "profileDescription",
            "openedDate", "lastPublicationDate", "reference", "region", "contractTypeNames",
            "businessDomains", "numberOfJobs"];

        $arrLink = array_combine($arrDB, $arrAPI);

        $arrInsert = [];
        foreach ($arrLink as $keyDB => $keyAPI) {
            if (isset($offre[$keyAPI])) {
                if (in_array($keyAPI, ["missionDescription", "businessDescription", "profileDescription"])) {
                    $arrInsert[$keyDB] = $this->cleanDescription($offre[$keyAPI]);
                } elseif (in_array($keyAPI, ["contractTypeNames", "businessDomains"])) {
                    $arrInsert[$keyDB] = $this->convertArray($offre[$keyAPI]);
                } elseif (in_array($keyAPI, ["lastPublicationDate", "openedDate"])) {
                    $arrInsert[$keyDB] = $this->formatDate($offre[$keyAPI]);
                } else {
                    $arrInsert[$keyDB] = $offre[$keyAPI];
                }
            }
        }

        return $arrInsert;
    }

    private function cleanDescription($description)
    {
        $desc = preg_replace(
            '/ (style=("|\')(.*?)("|\'))|(align=("|\')(.*?)("|\'))|(class=("|\')(.*?)("|\'))/',
            '',
            $description);

        return $desc;
    }

    private function convertArray($array)
    {
        return serialize($array);
    }

    private function formatDate($date)
    {
        $dateInit = new \DateTime($date);
        $dateFormat = $dateInit->format('Y-m-d H:i:s');
        return $dateFormat;
    }

    /**
     * Disable all offers that not return by the API
     * @param array $refs
     */
    private function disableAllOffresNotIn(array $refs)
    {
        if (!empty($refs)) {
            $this->offreRepository->disable($refs);
        }
    }
}