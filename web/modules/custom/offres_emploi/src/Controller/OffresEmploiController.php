<?php

namespace Drupal\offres_emploi\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Drupal\Core\Url;

/**
 * Defines OffresEmploiController class.
 */
class OffresEmploiController extends ControllerBase {

    protected $table;
    protected $connection;

    public function __construct()
    {
        $this->table = "offres_emploi";
        if ($this->getSiteName() == "groupecargo") {
            $this->connection = \Drupal::database();
        } else {
            //TODO: a voir avec jm
            $this->connection = \Drupal\Core\Database\Database::setActiveConnection('external');
        }
    }

    public function content($ref)
    {
        if ($ref == "all") {
            $offres = $this->getOffres();
            $build = [
                '#theme' => 'les-offres-emploi',
                '#data' => $offres
            ];
        } else {
            $offres = $this->getOffre($ref);
            $build = [
                '#theme' => 'annonce',
                '#data' => $offres
            ];
        }

        return $build;
    }

    public function getOffres()
    {
        $site_name = $this->getSiteName();

        if ($site_name == "groupecargo") {
            $all_offres = $this->connection->select($this->table,"cargo")
                ->fields("cargo")
                ->condition('active', 1, '=')
                ->execute()
                ->fetchAll();
        } else {
            $societe = $this->getNameDbSociete($site_name);
            $all_offres = $this->connection->select($this->table,"cargo")
                ->fields("cargo")
                ->condition('filialeSociete', $societe, '=')
                ->condition('active', 1, '=')
                ->execute()
                ->fetchAll();
        }

        return $all_offres;
    }

    public function getOffre($ref) {
        $site_name = $this->getSiteName();

        if ($site_name == "groupecargo") {
            $offre = $this->connection->select($this->table,"codeRecrutement")
                ->fields("codeRecrutement")
                ->condition('codeRecrutement', $ref, '=')
                ->condition('active', 1, '=')
                ->execute()
                ->fetchAssoc();
        } else {
            $societe = $this->getNameDbSociete($site_name);
            $offre = $this->connection->select($this->table,"codeRecrutement")
                ->fields("codeRecrutement")
                ->condition('filialeSociete', $societe, '=')
                ->condition('codeRecrutement', $ref, '=')
                ->condition('active', 1, '=')
                ->execute()
                ->fetchAssoc();
        }

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

    public function __destruct()
    {
        db_set_active('');
    }

}