<?php
namespace Drupal\offres_emploi\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Url;

class ImportController extends ControllerBase{

    protected $table;
    protected $connection;

    function __construct()
    {
        $this->table = "offres_emploi";
        if ($this->getSiteName() == "groupecargo") {
            $this->connection = \Drupal::database();
        } else {
            $this->connection = \Drupal::database();
            //$newdb = \Drupal\Core\Database\Database::setActiveConnection('external');
            //$this->connection = \Drupal::database();
//            $this->connection = \Drupal\Core\Database\Database::getConnection();
//            $this->connection = \Drupal\Core\Database\Database::getConnection('default', 'external');
        }
    }

    function execute()
    {
        $path = drupal_get_path('module', 'offres_emploi');
        $json_data = '['.rtrim(utf8_encode(file_get_contents($path.'/data/DemandeRecrutement.json')),',').']';
        $data = json_decode($json_data,true);

        foreach ($data as $offre)
        {
            $my_data = array();
            $this->pushDataInMyArray($my_data,$offre);//adapt data for database
            $my_data['active'] = 1;

            $all_ref_active[] = $my_data['codeRecrutement'];

            if ($this->searchOffre($my_data) === true) {
                $this->updateOffre($my_data);
            } else {
                $this->insertOffre($my_data);
            }
        }

        $desactivateOffres = $this->desactivateOffres($all_ref_active);

        var_dump('ok');
        die();
    }

    public function desactivateOffres($ref_active)
    {
        $desactivateOffres = $this->connection->update($this->table)
            ->fields(array('active'=>0))
            ->condition('codeRecrutement', $ref_active, 'NOT IN')
            ->execute();

        return $desactivateOffres;
    }

    private function pushDataInMyArray(&$arr_insert,$offre)
    {
        $arr_db = array("codeRecrutement","intitulePoste","dateCreationDemande","dateOuverturePoste","filialeSociete",
            "typeContrat","dureeContrat","categorie","metier","lieuRecrutement","descriptionEntreprise","descriptionMission",
            "descriptionProfil");
        $arr_json = array("CodeRecrutement","IntitulePosteARecruter","DateDemande","DateEmbaucheSouhaite","SocieteRecrutement",
            "TypeContrat","DureeDuContrat","Categorie","Metier","LieuRecrutement","DescriptionEntreprise","DescriptionMission",
            "DescriptionProfil");
        $arr_link = array_combine($arr_db,$arr_json);
        foreach ($arr_link as $keyDB => $keyJSON) {
            if (isset($offre[$keyJSON])) {
                if (array_search($keyJSON, array("","DescriptionEntreprise","DescriptionMission","DescriptionProfil"))) {
                    $arr_insert[$keyDB] = preg_replace(
                        '/ (style=("|\')(.*?)("|\'))|(align=("|\')(.*?)("|\'))/',
                        '',
                        $offre[$keyJSON]
                    );
                } else {
                    $arr_insert[$keyDB] = $offre[$keyJSON];
                }
            }
        }
    }

    public function searchOffre($datainsert)
    {
        $insertOffre = $this->connection->select($this->table,'cargo')
            ->fields('cargo')
            ->condition('codeRecrutement', $datainsert['codeRecrutement'], '=')
            ->execute()
            ->fetchAssoc();
        if (is_array($insertOffre)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function insertOffre($datainsert)
    {
        $insertOffre = $this->connection->insert($this->table)
            ->fields($datainsert)
            ->execute();
        return $insertOffre;
    }

    public function updateOffre($datainsert)
    {
        $updateOffre = $this->connection->update($this->table)
            ->fields($datainsert)
            ->condition('codeRecrutement', $datainsert['codeRecrutement'], '=')
            ->execute();
        return $updateOffre;
    }

    private function getSiteName() {
        $site_path = \Drupal::service('site.path');
        $site_path = explode('/', $site_path);
        $site_name = $site_path[1];

        return $site_name;
    }

    public function __destruct()
    {
        //$olddb = \Drupal\Core\Database\Database::setActiveConnection();
        //$this->connection = \Drupal::database();
    }


}