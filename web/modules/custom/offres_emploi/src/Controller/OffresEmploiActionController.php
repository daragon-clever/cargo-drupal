<?php

namespace Drupal\offres_emploi\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Url;
use Symfony\Component\HttpFoundation\Request;
use \Drupal\Core\Database\Database;

class OffresEmploiActionController extends ControllerBase
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


    public function postuler($ref)
    {
        if (isset($ref)) {
            $webform = \Drupal::entityTypeManager()->getStorage('webform')->load('postuler_annonce');

            $dataPoste = $this->getOffre($ref);
            $namePoste = $dataPoste["intitulePoste"];

            $build = [
                '#theme' => 'offres_emploi--form-postuler',
                '#data' => $namePoste,
                "#form" => $webform->getSubmissionForm()
            ];

            return $build;
        } else {
            die();
        }
    }

    public function getOffre($ref)
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
}