<?php
declare(strict_types=1);

namespace Drupal\offres_emploi\Command;

use Drupal\offres_emploi\Helper\OffreEmploiHelperTrait;
use Drupal\offres_emploi\OffreEmploiRepository;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Drupal\Console\Core\Command\Command;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ImportCommand.
 *
 * Drupal\Console\Annotations\DrupalCommand (
 *     extension="offres_emploi",
 *     extensionType="module"
 * )
 */
class ImportCommand extends Command
{

    /**
     * Name of the Console Command
     */
    private const COMMAND_NAME = 'offres_emploi:import';

    /**
     * Name of the project cargo where the json is stored
     */
    private const NAMECARGODIRECTORYPROJECT = 'groupecargo';

    /**
     * List of all sites that use Drupal
     * @var array
     */
    private const NAMECOMPANY = [
        'ostaria' => 'C2S',
        'comptoirdefamille' => 'Comptoir de Famille',
        'technosource-industrie' => 'TECHNO SOURCE INDUSTRIES',
        'cestdeuxeuros' => 'CEDIF',
        'yliades' => 'YLIADES',
        'roldan' => 'ROLDAN',
        'merchetcie' => 'MERCH ET CIE',
        'groupecargo' => 'CARGO',
        'cogex' => 'COGEX',
        'ruecab' => 'RUECAB',
        'gersequipement' => 'GERS EQUIPEMENT',
        'turbocar' => 'TURBOCAR',
    ];

    /**
     * @var OffreEmploiRepository
     */
    private $offreRepository;

    private $siteName;

    use OffreEmploiHelperTrait;


    public function __construct(OffreEmploiRepository $offreRepository)
    {
        $this->siteName = $this->getSiteName();
        $this->offreRepository = $offreRepository;
        parent::__construct();
    }


    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName(self::COMMAND_NAME)
            ->setDescription('Importing Offres Emploi')
        ;
    }


    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        \Drupal::logger('offres_emploi')->notice('[OFFRES EMPLOI] Lancement cron');
        $this->getIo()->info('[OFFRES EMPLOI] Lancement cron');


        //launch the import
        $this->import();

        drupal_flush_all_caches();

        $this->getIo()->info('[OFFRES EMPLOI] Cron terminé');
        \Drupal::logger('offres_emploi')->notice('[OFFRES EMPLOI] Cron terminé');
    }


    /**
     * Execute the Import from the json
     * Import Only offer that match with the website
     */
    private function import()
    {
        $path = $this->getPathFile();

        $fileData = file_get_contents($path . '/data/V_DemandeRecrutementOuvert.json');

        if ($fileData !== false) {
            $data = json_decode($fileData, true);

            $allRefsActive = [];
            foreach ($data as $offre) {
                if ($offre['SocieteRecrutement'] === self::NAMECOMPANY[$this->siteName] || $this->siteName === self::NAMECARGODIRECTORYPROJECT) {

                    $dataHydrated = $this->hydrateData($offre);
                    $dataHydrated['active'] = 1;

                    $allRefsActive[] = $dataHydrated['codeRecrutement'];

                    $offreExist = $this->offreRepository->findBy($dataHydrated);
                    if ($offreExist) {
                        $this->offreRepository->update($dataHydrated);
                    } else {
                        $this->offreRepository->insert($dataHydrated);
                    }
                }
            }

            //Disable all offers that not in the data json
            $this->offreRepository->disable($allRefsActive);

            return $this->getIo()->info('[OFFRES EMPLOI] importing offers done with success !');
        }
        return $this->getIo()->info('[OFFRES EMPLOI] Error importing offers !');
    }


    /**
     * Hydrate Data
     * @param $offre
     * @return array
     */
    private function hydrateData($offre): array
    {
        $arrDB = ["codeRecrutement", "intitulePoste", "dateCreationDemande", "dateOuverturePoste", "filialeSociete",
            "typeContrat", "dureeContrat", "categorie", "metier", "lieuRecrutement", "descriptionEntreprise", "descriptionMission",
            "descriptionProfil"];
        $arrJSON = ["CodeRecrutement", "IntitulePosteARecruter", "DateDemande", "DateEmbaucheSouhaite", "SocieteRecrutement",
            "TypeContrat", "DureeDuContrat", "Categorie", "Metier", "LieuRecrutement", "DescriptionEntreprise", "DescriptionMission",
            "DescriptionProfil"];

        $arrLink = array_combine($arrDB, $arrJSON);

        $arrInsert = [];
        foreach ($arrLink as $keyDB => $keyJSON) {
            if (isset($offre[$keyJSON])) {
                if (in_array($keyJSON, ["DescriptionEntreprise", "DescriptionMission", "DescriptionProfil"])) {
                    $arrInsert[$keyDB] = $this->cleanDescription($offre[$keyJSON]);
                } else {
                    $arrInsert[$keyDB] = $offre[$keyJSON];
                }
            }
        }

        return $arrInsert;
    }

    /**
     * Clean Description
     * @param $descriptionTxt
     * @return string|string[]
     */
    private function cleanDescription($descriptionTxt): string
    {
        $desc = preg_replace(
            '/ (style=("|\')(.*?)("|\'))|(align=("|\')(.*?)("|\'))/',
            '',
            $descriptionTxt);
        $search = [
            "",
            "",
            "",
            "&nbsp;"
        ];
        $replacements = [
            "...",
            "'",
            "oe",
            ""
        ];
        $desc = str_replace($search, $replacements, $desc);

        return $desc;
    }


    /**
     * Access to folder from cargo site
     * @return string
     */
    private function getPathFile(): string
    {
        $fileSystem = \Drupal::service('file_system');
        $path = $fileSystem->realpath(file_default_scheme() . "://");

        return str_replace($this->siteName, self::NAMECARGODIRECTORYPROJECT, $path);
    }
}
