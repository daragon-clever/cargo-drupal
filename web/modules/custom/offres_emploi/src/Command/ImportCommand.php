<?php
declare(strict_types=1);

namespace Drupal\offres_emploi\Command;

use Drupal\offres_emploi\Helper\OffreEmploiHelperTrait;
use Drupal\offres_emploi\OffreEmploiRepository;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Drupal\Console\Core\Command\Command;

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
    private const NAME_CARGO_DIRECTORY_PROJECT = 'groupecargo';

    /**
     * Json Path File
     */
    private const JSON_FILE_PATH = '/data/V_DemandeRecrutementOuvert.json';

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
        \Drupal::logger('offres_emploi')->notice('[OFFRES EMPLOI] Lancement import');
        $this->getIo()->info('[OFFRES EMPLOI] Lancement import');

        //launch the import
        $this->import();

        drupal_flush_all_caches();

        $this->getIo()->info('[OFFRES EMPLOI] import terminé');
        \Drupal::logger('offres_emploi')->notice('[OFFRES EMPLOI] import terminé');
    }

    /**
     * Execute the Import from the json
     * Import Only offer that match with the website
     */
    private function import()
    {
        $path = $this->getPathFile();

        $fileData = file_get_contents($path . self::JSON_FILE_PATH);

        if (!is_null($fileData) && $this->checkIfJsonIsValid($fileData)) {
            $data = json_decode($fileData, true, 512, JSON_BIGINT_AS_STRING);

            if (is_array($data) && !empty($data)) {
                $allRefsActive = [];
                foreach ($data as $offre) {
                    if ($offre['SocieteRecrutement'] === self::$nameCompany[$this->siteName] || $this->siteName === self::NAME_CARGO_DIRECTORY_PROJECT) {

                        $dataHydrated = $this->hydrateData($offre);
                        $dataHydrated['active'] = 1;

                        $allRefsActive[] = $dataHydrated['codeRecrutement'];

                        $offreExist = $this->offreRepository->findBy(['codeRecrutement' => $dataHydrated['codeRecrutement']]);

                        if ($offreExist) {
                            $this->getIo()->info('[OFFRES EMPLOI] Starting Updating Offer with codeRecrutement: ' . current($offreExist)->codeRecrutement);
                            $this->offreRepository->update($dataHydrated);
                        } else {
                            $this->getIo()->info('[OFFRES EMPLOI] Starting Creating Offer with codeRecrutement: ' . $dataHydrated['codeRecrutement']);
                            $this->offreRepository->insert($dataHydrated);
                        }
                    }
                }
                $this->offreRepository->disable($allRefsActive);
            }

            return $this->getIo()->info('[OFFRES EMPLOI] importing offers done with success !');
        }
        \Drupal::logger('offres_emploi')->error('[OFFRES EMPLOI] Error importing offers ! No Data or Json file is invalid');
        return $this->getIo()->error('[OFFRES EMPLOI] Error importing offers ! No Data or Json file is invalid');
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
            "descriptionProfil", "sirh_id"];
        $arrJSON = ["CodeRecrutement", "IntitulePosteARecruter", "DateDemande", "DateEmbaucheSouhaite", "SocieteRecrutement",
            "TypeContrat", "DureeDuContrat", "Categorie", "Metier", "LieuRecrutement", "DescriptionEntreprise", "DescriptionMission",
            "DescriptionProfil", "IdReferenceSIRH"]; //Manquant dans le nouveau JSON : DateEmbaucheSouhaite + Categorie + Metier + LieuRecrutement

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

        return str_replace($this->siteName, self::NAME_CARGO_DIRECTORY_PROJECT, $path);
    }

    /**
     * Check if the Json is Valid
     * @param $data
     * @return bool
     */
    private function checkIfJsonIsValid($data): bool
    {
        json_decode($data);
        return (json_last_error() === JSON_ERROR_NONE);
    }
}
