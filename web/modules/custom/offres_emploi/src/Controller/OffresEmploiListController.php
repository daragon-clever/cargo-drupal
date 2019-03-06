<?php

namespace Drupal\offres_emploi\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Url;
use \Drupal\Core\Database\Database;
use Symfony\Component\HttpFoundation\Request;

/**
 * Defines OffresEmploiListController class.
 */
class OffresEmploiListController extends ControllerBase {

    public $siteName;
    private $table;
    protected $actualTime;
    private $ipAddress;
    private $fileLogIPAnnonce;

    private $conn;

    public function __construct()
    {
        $this->siteName = $this->getSiteName();
        $this->table = "offres_emploi";
        $this->actualTime = time();
        $this->ipAddress = $_SERVER['REMOTE_ADDR'];

        /* GET FILE WHICH CONTAIN ALL VISITOR'S IP ADDRESS */
        $this->setLogFile();
        /* END OF GET FILE */

        $this->setDatabaseConn();
    }

    private function getSiteName() {
        $sitePath = \Drupal::service('site.path');
        $sitePath = explode('/', $sitePath);
        $siteName = $sitePath[1];

        return $siteName;
    }

    private function setLogFile()
    {
        $folderFiles = \Drupal::service('file_system')->realpath(file_default_scheme() . "://");
        if (!file_exists($folderFiles.'/log')) {
            mkdir($folderFiles . "/log",0777,true);
        }
        $this->fileLogIPAnnonce = $folderFiles . "/log/logip--annonce.csv";
        if (!file_exists($this->fileLogIPAnnonce)) {
            file_put_contents($this->fileLogIPAnnonce,"ref,ip,time"."\n");
        }
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

    public function content($ref, Request $request)
    {

        if ($ref == "all") {
            //récupère les filtres
            $arrFilter = $this->getAllFilters($request);

            //return une liste d'offre
            $offres = $this->getOffres();

            //construit le thème
            $build = [
                '#theme' => 'offres_emploi--list',
                '#data' => $offres,
                '#filter' => $arrFilter
            ];
        } else {
            //retour une seule offre
            $offre = $this->getOffre($ref);
            if ($offre === FALSE) {
                //si la ref de l'offre passée en parm n'existe pas
                $build = [
                    '#theme' => 'offres_emploi--annonce',
                    '#data' => ($offre) ? 'true' : 'false'
                ];
            } else {
                $search = $this->searchInCSV($ref);
                if ($search === false) {
                    $this->logIpAddressOnFile($ref);
                    $this->updataNbVue($ref);
                }
                $build = [
                    '#theme' => 'offres_emploi--annonce',
                    '#data' => $offre
                ];
            }
        }

        return $build;
    }

    /*
     * Get filters _GET of the request
     */
    private function getAllFilters($req)
    {
        return array(
            "filiale_societe" => $req->get("filiale_societe"),
            "type_contrat" => $req->get("type_contrat"),
            "type_metier" => $req->get("type_metier"),
            "lieu" => $req->get("lieu")
        );
    }

    /*
     * Get all offers
     */
    private function getOffres()
    {
        if ($this->siteName == "groupecargo") {
            $all_offres = $this->conn->select($this->table,"cargo")
                ->fields("cargo")
                ->condition('active', 1, '=')
                ->execute()
                ->fetchAll();
        } else {
            $societe = $this->getNameDbSociete();
            $all_offres = $this->conn->select($this->table,"cargo")
                ->fields("cargo")
                ->condition('filialeSociete', $societe, '=')
                ->condition('active', 1, '=')
                ->execute()
                ->fetchAll();
        }

        return $all_offres;
    }

    /*
     * Get 1 offer
     */
    private function getOffre($ref)
    {
        if ($this->siteName == "groupecargo") {
            $offre = $this->conn->select($this->table,"codeRecrutement")
                ->fields("codeRecrutement")
                ->condition('codeRecrutement', $ref, '=')
                ->condition('active', 1, '=')
                ->execute()
                ->fetchAssoc();
        } else {
            $societe = $this->getNameDbSociete();
            $offre = $this->conn->select($this->table,"codeRecrutement")
                ->fields("codeRecrutement")
                ->condition('filialeSociete', $societe, '=')
                ->condition('codeRecrutement', $ref, '=')
                ->condition('active', 1, '=')
                ->execute()
                ->fetchAssoc();
        }

        return $offre;
    }

    private function getNameDbSociete() {
        $allNameDrupal = array("blog-sitram","ostaria","turbocar","yliades");
        $allNameJson = array("sitram","ostaria","turbocar","yliades");
        $arr = array_combine($allNameDrupal, $allNameJson);

        $data = $arr[$this->siteName];

        return $data;
    }


    private function searchInCSV($ref)
    {
        $arrCSVcontent = $this->getCSV();
        $new_arr = array_reverse($arrCSVcontent);
        foreach ($new_arr as $key => $val) {
            if ($val['ip'] == $this->ipAddress && $val['ref'] == $ref) {
                $found_time = $val['time'];
                break;
            }
        }

        $fiveMin = $this->actualTime - (60*5);
        if (isset($foundTime) && $foundTime > $fiveMin) {
            return true;
        } else {
            return false;
        }
    }

    private function getCSV()
    {
        $csv = explode("\n", file_get_contents($this->fileLogIPAnnonce));

        foreach ($csv as $key => $line)
        {
            $csv[$key] = str_getcsv($line);
        }
        $entete = $csv[0];
        unset($csv[0]);

        foreach ($csv as $item) {
            $combine[] = array_combine($entete,$item);
        }
        array_pop($combine);

        return $combine;
    }

    private function logIpAddressOnFile($ref)
    {
        file_put_contents($this->fileLogIPAnnonce, $ref.",".$this->ipAddress.",".$this->actualTime."\n", FILE_APPEND | LOCK_EX);
    }

    /*
     * Update nbVue +1 in database of an offer
     */
    private function updataNbVue($ref)
    {
        $nbvue = $this->conn->update($this->table)
            ->expression('nbVue', 'nbVue + 1')
            ->condition('codeRecrutement', $ref, '=')
            ->execute();

        return $nbvue;
    }


    public function __destruct()
    {
        $this->conn = null;
    }

}