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

    public $site_name;
    protected $table;
    protected $actual_time;
    private $ip_address;
    protected $file_logip_annonce;

    public function __construct()
    {
        $this->site_name = $this->getSiteName();
        $this->table = "offres_emploi";
        $this->actual_time = time();
        $this->ip_address = $_SERVER['REMOTE_ADDR'];

        /* GET FILE WHICH CONTAIN ALL VISITOR'S IP ADDRESS */
        $folder_files = \Drupal::service('file_system')->realpath(file_default_scheme() . "://");
        if (!file_exists($folder_files.'/log')) {
            mkdir($folder_files . "/log",0777,true);
        }
        $this->file_logip_annonce = $folder_files . "/log/logip--annonce.csv";
        if (!file_exists($this->file_logip_annonce)) {
            file_put_contents($this->file_logip_annonce,"ref,ip,time"."\n");
        }
        /* END OF GET FILE */

//        $host = 'db.groupecargo.svd2pweb-stm.ressinfo.ad:3306';
//        $db = "groupecargo";
//        $user = "root";
//        $pass = "root";
//
//        try{
//             create a PDO connection with the configuration data
//            $conn = new \PDO("mysql:host=$host;dbname=$db", $user, $pass);
//
//             display a message if connected to database successfully
//            if($conn){
//                echo "Connected to the <strong>$db</strong> database successfully!";
//            }
//        }catch (PDOException $e){
//             report error message
//            echo $e->getMessage();
//        }
//
//        die();
    }

    public function content($ref, Request $request)
    {
        $arr_filter = $this->getAllFilters($request);

        if ($ref == "all") {
            //return une liste d'offre
            $offres = $this->getOffres();
            $build = [
                '#theme' => 'offres_emploi--list',
                '#data' => $offres,
                '#filter' => $arr_filter
            ];
        } else {
            //retour une seule offre
            $offre = $this->getOffre($ref);
            if ($offre === FALSE) {
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
        $connection = $this->changeDb("on");

        if ($this->site_name == "groupecargo") {
            $all_offres = $connection->select($this->table,"cargo")
                ->fields("cargo")
                ->condition('active', 1, '=')
                ->execute()
                ->fetchAll();
        } else {
            $societe = $this->getNameDbSociete();
            $all_offres = $connection->select($this->table,"cargo")
                ->fields("cargo")
                ->condition('filialeSociete', $societe, '=')
                ->condition('active', 1, '=')
                ->execute()
                ->fetchAll();
        }

        $connection = $this->changeDb("off");

        return $all_offres;
    }

    /*
     * Get 1 offer
     */
    private function getOffre($ref) {
        $connection = $this->changeDb("on");

        if ($this->site_name == "groupecargo") {
            $offre = $connection->select($this->table,"codeRecrutement")
                ->fields("codeRecrutement")
                ->condition('codeRecrutement', $ref, '=')
                ->condition('active', 1, '=')
                ->execute()
                ->fetchAssoc();
        } else {
            $societe = $this->getNameDbSociete($this->site_name);
            $offre = $connection->select($this->table,"codeRecrutement")
                ->fields("codeRecrutement")
                ->condition('filialeSociete', $societe, '=')
                ->condition('codeRecrutement', $ref, '=')
                ->condition('active', 1, '=')
                ->execute()
                ->fetchAssoc();
        }

        $connection = $this->changeDb("off");

        return $offre;
    }

    private function getSiteName() {
        $site_path = \Drupal::service('site.path');
        $site_path = explode('/', $site_path);
        $site_name = $site_path[1];

        return $site_name;
    }

    private function getNameDbSociete() {
        $all_name_drupal = array("blog-sitram","ostaria","turbocar","yliades");
        $all_name_json = array("sitram","ostaria","turbocar","yliades");
        $arr = array_combine($all_name_drupal, $all_name_json);

        $data = $arr[$this->site_name];

        return $data;
    }

    /*
     * Update nbVue +1 in database of an offer
     */
    private function updataNbVue($ref)
    {
        $connection = $this->changeDb("on");

        $nbvue = $connection->update($this->table)
            ->expression('nbVue', 'nbVue + 1')
            ->condition('codeRecrutement', $ref, '=')
            ->execute();

        $connection = $this->changeDb("off");

        return $nbvue;
    }

    private function logIpAddressOnFile($ref)
    {
        file_put_contents($this->file_logip_annonce, $ref.",".$this->ip_address.",".$this->actual_time."\n", FILE_APPEND | LOCK_EX);
    }

    private function getCSV()
    {
        $csv = explode("\n", file_get_contents($this->file_logip_annonce));

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

    private function searchInCSV($ref)
    {
        $arr_csv_content = $this->getCSV();
        $new_arr = array_reverse($arr_csv_content);
        foreach ($new_arr as $key => $val) {
            if ($val['ip'] == $this->ip_address && $val['ref'] == $ref) {
                $found_time = $val['time'];
                break;
            }
        }

        $five_min = $this->actual_time - (60*5);
        if (isset($found_time) && $found_time > $five_min) {
            return true;
        } else {
            return false;
        }
    }

    //todo: a revoir et mettre dans le constructeur
    private function changeDb($etat_on_off)
    {
        if ($this->site_name == "groupecargo") {
            $conn = \Drupal::database();
        } else {
            if ($etat_on_off == "on") {
                $old_key = Database::setActiveConnection('external');
            } else if ($etat_on_off == "off") {
                Database::setActiveConnection();
            }
            $conn = Database::getConnection();
//            $conn = \Drupal::database();
        }
        return $conn;
    }

    public function __destruct()
    {
        /*if (!($this->site_name == "groupecargo")) {
//            \Drupal\Core\Database\Database::setActiveConnection();
            Database::setActiveConnection($this->old_key);
        }*/
    }

}