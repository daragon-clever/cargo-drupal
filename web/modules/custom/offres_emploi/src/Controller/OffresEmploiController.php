<?php

namespace Drupal\offres_emploi\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Url;
use \Drupal\Core\Database\Database;

/**
 * Defines OffresEmploiController class.
 */
class OffresEmploiController extends ControllerBase {

    protected $table;

    public function __construct()
    {
        $this->table = "offres_emploi";

        /*$host = 'db.groupecargo.svd2pweb-stm.ressinfo.ad:3306';
        $db = "groupecargo";
        $user = "root";
        $pass = "root";

        try{
            // create a PDO connection with the configuration data
            $conn = new \PDO("mysql:host=$host;dbname=$db", $user, $pass);

            // display a message if connected to database successfully
            if($conn){
                echo "Connected to the <strong>$db</strong> database successfully!";
            }
        }catch (PDOException $e){
            // report error message
            echo $e->getMessage();
        }

        die();*/

    }

    public function content($ref)
    {
        if ($ref == "all") {
            $offres = $this->getOffres();
            $build = [
                '#theme' => 'offres_emploi--list',
                '#data' => $offres
            ];
        } else {
            $offres = $this->getOffre($ref);
            $build = [
                '#theme' => 'offres_emploi--annonce',
                '#data' => $offres
            ];
        }

        return $build;
    }

    public function getOffres()
    {
        $site_name = $this->getSiteName();
        $connection = $this->changeDb("on");

        if ($site_name == "groupecargo") {
            $all_offres = $connection->select($this->table,"cargo")
                ->fields("cargo")
                ->condition('active', 1, '=')
                ->execute()
                ->fetchAll();
        } else {
            $societe = $this->getNameDbSociete($site_name);
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

    public function getOffre($ref) {
        $site_name = $this->getSiteName();
        $connection = $this->changeDb("on");

        if ($site_name == "groupecargo") {
            $offre = $connection->select($this->table,"codeRecrutement")
                ->fields("codeRecrutement")
                ->condition('codeRecrutement', $ref, '=')
                ->condition('active', 1, '=')
                ->execute()
                ->fetchAssoc();
        } else {
            $societe = $this->getNameDbSociete($site_name);
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

    public function getNameDbSociete($site_name) {
        $all_name_drupal = array("blog-sitram","ostaria","turbocar","yliades");
        $all_name_json = array("sitram","ostaria","turbocar","yliades");
        $arr = array_combine($all_name_drupal, $all_name_json);

        $data = $arr[$site_name];

        return $data;
    }

    private function getSiteName() {
        $site_path = \Drupal::service('site.path');
        $site_path = explode('/', $site_path);
        $site_name = $site_path[1];

        return $site_name;
    }

    //todo:  a revoir
    private function changeDb($etat_on_off)
    {
        if ($this->getSiteName() == "groupecargo") {
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

    /*public function __destruct()
    {
        if (!($this->getSiteName() == "groupecargo")) {
//            \Drupal\Core\Database\Database::setActiveConnection();
            Database::setActiveConnection($this->old_key);
        }
    }*/

}