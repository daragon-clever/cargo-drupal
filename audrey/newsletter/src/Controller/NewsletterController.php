<?php

namespace Drupal\newsletter\Controller;

use Drupal\Core\Controller\ControllerBase;

class NewsletterController extends ControllerBase
{
    protected $tableSubscribers;
    protected $tableSubscriptions;

    public function __construct()
    {
        $this->tableSubscribers = "newsletter_subscriber";
        $this->tableSubscriptions = "newsletter_subscription";
    }

    public function content()
    {
        $siteName = \Drupal::config('system.site')->get('name');
        switch (strtolower($siteName)) {
            case "yliades":
                $myform = \Drupal::formBuilder()->getForm('Drupal\newsletter\Form\YliadesForm');
                break;
            case "blog-sitram":
                $myform = \Drupal::formBuilder()->getForm('Drupal\newsletter\Form\BlogSitramForm');
                break;
            default:
                $msg = "Pas de formulaire newsletter pour ce site";
        }

        if (isset($myform)) {
            $build = [
                '#theme' => 'inscription',
                '#form' => $myform
            ];
        } else {
            $build = [
                '#theme' => 'inscription',
                '#msg' => $msg
            ];
        }

        return $build;
    }

    //todo: à revoir
    public function doAction($choixMarques, $email)
    {
        $connection = \Drupal::database();
        $msg = "";
        $exported = 0;

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
                "cote_table" => $marques["cote_table"],//todo: all value of table subscriber + add insert on subscription
                "exported" => $exported
            ])
            ->execute();
        return $insertPeople;
    }

    public function updatePeople($connection,$table,$email,$marques)
    {
        $updatePeople = $connection->update($table)
            ->fields([
                'cote_table' => $marques['cote_table']//todo: all value of table subscriber + update subscription
            ])
            ->condition('email', $email, '=')
            ->execute();
        return $updatePeople;
    }
}