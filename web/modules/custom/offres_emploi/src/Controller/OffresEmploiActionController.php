<?php

namespace Drupal\offres_emploi\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Url;
use Symfony\Component\HttpFoundation\Request;
use \Drupal\Core\Database\Database;

class OffresEmploiActionController extends ControllerBase
{
    public $table;

    public function __construct()
    {
        $this->table = "offres_emploi";
    }
    public function postuler($ref)
    {
        if (!(isset($ref))) {
            die();
        } else {
            $webform = \Drupal::entityTypeManager()->getStorage('webform')->load('postuler_annonce');

            $data_poste = $this->getOffre($ref);
            $name_poste = $data_poste["intitulePoste"];

            $build = [
                '#theme' => 'offres_emploi--form-postuler',
                '#data' => $name_poste,
                "#form" => $webform->getSubmissionForm()
            ];

            return $build;
        }

    }

    public function getOffre($ref)
    {
        $conn = \Drupal::database();
        $offre = $conn->select($this->table,"codeRecrutement")
            ->fields("codeRecrutement")
            ->condition('codeRecrutement', $ref, '=')
            ->condition('active', 1, '=')
            ->execute()
            ->fetchAssoc();

        return $offre;
    }


    //todo : if ref is not in select list ref
}