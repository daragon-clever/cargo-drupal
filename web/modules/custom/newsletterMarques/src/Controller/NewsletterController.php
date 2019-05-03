<?php

namespace Drupal\newsletterMarques\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Drupal\Core\Url;

/**
 * Defines NewsletterController class.
 */
class NewsletterController extends ControllerBase {

    protected $table;
    protected $lesMarque;

    public function __construct()
    {
        $this->table = "newsletter_marques";
        $this->lesMarque = [
            'toutes_les_marques',
            'sema_design',
            'comptoir_de_famille',
            'cote_table',
            'genevieve_lethu',
            'jardin_d_ulysse'
        ];
    }

    public function content() {

        $myform = \Drupal::formBuilder()->getForm('Drupal\newsletterMarques\Form\CustomForm');

        $build = [
            '#theme' => 'newsletter',
            '#form' => $myform
        ];

        return $build;
    }

    public function doAction($choixMarques,$email)
    {
        $connection = \Drupal::database();
        $msg = "";//initialize var msg
        $exported = 0;//initialize exported - actito

        $marques = $this->initializeFieldSociety();//get array with all brands (value -> 0)-

        foreach ($choixMarques as $key => $value) {
            if (is_string($value)) {
                if ($value == "toutes_les_marques" && $key == "toutes_les_marques") {
                    $marques = $this->fieldAllSociety();
                    break;
                } else {
                    $marques[$value] = 1;
                }
            }
        }

        $people = $this->getPeople($connection,$this->table,$email);

        if (empty($people) || $people == false) {
            $insertPeople = $this->insertPeople($connection,$this->table,$email,$marques,$exported);
            $msg = 'insert';//"Vous venez de vous inscrire à la newsletter"
        } else {
            $updatePeople = $this->updatePeople($connection,$this->table,$email,$marques);
            $msg = 'update';//"Vous venez de mettre à jour votre préférence pour la newsletter"
        }

        return $msg;
    }

    public function getPeople($connection,$table,$email)
    {
        $people = $connection->select($table,'email')
            ->fields('email')
            ->condition('email', $email,'=')
            ->execute()
            ->fetchAssoc();
        return $people;
    }

    public function insertPeople($connection,$table,$email,$marques,$exported)
    {
        $insertPeople = $connection->insert($table)
            ->fields([
                "email" => $email,
                "cote_table" => $marques["cote_table"],
                "comptoir_de_famille" => $marques["comptoir_de_famille"],
                "jardin_d_ulysse" => $marques["jardin_d_ulysse"],
                "genevieve_lethu" => $marques["genevieve_lethu"],
                "sema_design" => $marques["sema_design"],
                "exported" => $exported
            ])
            ->execute();
        return $insertPeople;
    }

    public function updatePeople($connection,$table,$email,$marques)
    {
        $updatePeople = $connection->update($table)
            ->fields([
                'cote_table' => $marques['cote_table'],
                'comptoir_de_famille' => $marques['comptoir_de_famille'],
                'jardin_d_ulysse' => $marques['jardin_d_ulysse'],
                'genevieve_lethu' => $marques['genevieve_lethu'],
                'sema_design' => $marques['sema_design'],
            ])
            ->condition('email', $email, '=')
            ->execute();
        return $updatePeople;
    }

    public function initializeFieldSociety()
    {
        foreach ($this->lesMarque as $value)
        {
            $newArray[$value] = 0;
        }
        return $newArray;
    }

    public function fieldAllSociety()
    {
        foreach ($this->lesMarque as $value)
        {
            $newArray[$value] = 1;
        }
        return $newArray;
    }

}