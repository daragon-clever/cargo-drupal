<?php
namespace Drupal\offres_emploi\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Url;

class ImportController extends ControllerBase
{
    public $siteName;
    public $table;
    private $conn;

    public function __construct()
    {
        $this->siteName = $this->getSiteName();
        $this->table = "offres_emploi";
        $this->setDatabaseConn();
    }

    private function getSiteName() {
        $sitePath = \Drupal::service('site.path');
        $sitePath = explode('/', $sitePath);
        $siteName = $sitePath[1];

        return $siteName;
    }

    private function setDatabaseConn()
    {
        if ($this->siteName == "groupecargo") {
            $this->conn = \Drupal::database();
        } else {
            Database::setActiveConnection('external');
            $this->conn = Database::getConnection();
        }

        return $this->conn;
    }

    public function execute()
    {
        $path = \Drupal::service('file_system')->realpath(file_default_scheme() . "://");
        $getContents = file_get_contents($path.'/data/V_DemandeRecrutementOuvert.json');
        $data = json_decode($getContents,true);

        $allRefsActive = array();
        foreach ($data as $offre) {
            $myData = array();
            $this->pushDataInMyArray($myData,$offre);//adapt data for database
            $myData['active'] = 1;

            $allRefsActive[] = $myData['codeRecrutement'];

            if ($this->searchOffre($myData['codeRecrutement']) === true) {
                $this->updateOffre($myData);
            } else {
                $this->insertOffre($myData);
            }
        }

        $desactivateOffres = $this->desactivateOffres($allRefsActive);
    }

    private function searchOffre($codeRecrutement)
    {
        $insertOffre = $this->conn->select($this->table,'cargo')
            ->fields('cargo')
            ->condition('codeRecrutement', $codeRecrutement, '=')
            ->execute()
            ->fetchAssoc();
        if (is_array($insertOffre)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    private function updateOffre($dataUpdate)
    {
        $updateOffre = $this->conn->update($this->table)
            ->fields($dataUpdate)
            ->condition('codeRecrutement', $dataUpdate['codeRecrutement'], '=')
            ->execute();
        return $updateOffre;
    }

    private function insertOffre($dataInsert)
    {
        $insertOffre = $this->conn->insert($this->table)
            ->fields($dataInsert)
            ->execute();
        return $insertOffre;
    }

    private function desactivateOffres($refsActive)
    {
        $desactivateOffres = $this->conn->update($this->table)
            ->fields(array('active'=>0))
            ->condition('codeRecrutement', $refsActive, 'NOT IN')
            ->execute();

        return $desactivateOffres;
    }


    private function pushDataInMyArray(&$arrInsert,$offre)
    {
        $arrDB = array("codeRecrutement","intitulePoste","dateCreationDemande","dateOuverturePoste","filialeSociete",
            "typeContrat","dureeContrat","categorie","metier","lieuRecrutement","descriptionEntreprise","descriptionMission",
            "descriptionProfil");
        $arrJSON = array("CodeRecrutement","IntitulePosteARecruter","DateDemande","DateEmbaucheSouhaite","SocieteRecrutement",
            "TypeContrat","DureeDuContrat","Categorie","Metier","LieuRecrutement","DescriptionEntreprise","DescriptionMission",
            "DescriptionProfil");
        $arrLink = array_combine($arrDB,$arrJSON);
        foreach ($arrLink as $keyDB => $keyJSON) {
            if (isset($offre[$keyJSON])) {
                if (in_array($keyJSON, array("DescriptionEntreprise","DescriptionMission","DescriptionProfil"))) {
                    $arrInsert[$keyDB] = $this->cleanDescription($offre[$keyJSON]);
                } else {
                    $arrInsert[$keyDB] = $offre[$keyJSON];
                }
            }
        }
    }

    private function cleanDescription($descriptionTxt)
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


    public function __destruct()
    {
        $this->conn = null;
    }
}