<?php

namespace Drupal\newsletter\Controller\Company;


use Drupal\Core\Datetime\DrupalDateTime;
use Drupal\newsletter\Controller\NewsletterController;

class YliadesController extends NewsletterController
{
    private $lesMarques;

    public function __construct()
    {
        NewsletterController::__construct();

        $this->lesMarques = [
            'toutes_les_marques',
            'sema_design',
            'comptoir_de_famille',
            'cote_table',
            'genevieve_lethu',
            'jardin_d_ulysse'
        ];
    }

    public function doAction($arrayData)
    {
        $marques = $this->setValueAllBrands(0);//get array with all brands (value -> 0)

        foreach ($arrayData['brands'] as $key => $value) {
            if (is_string($value)) {
                if ($value == "toutes_les_marques" && $key == "toutes_les_marques") {
                    $marques = $this->setValueAllBrands(1);
                    break;
                } else {
                    $marques[$value] = 1;
                }
            }
        }
        $arrayData['brands'] = $marques;

        $people = $this->getPeople($arrayData['email']);

        if (empty($people) || $people == false) {
            $this->insertPeople($arrayData);
            $action = 'insert';
        } else {
            $this->updatePeople($arrayData);
            $action = 'update';
        }

        return $this->displayMsg($action);
    }

    private function setValueAllBrands($val)
    {
        foreach ($this->lesMarques as $value)
        {
            $newArray[$value] = $val;
        }
        return $newArray;
    }

    /*********
     * SCHEMA
     *********/
    public function setSchemaTableSubscriber()
    {
        $array = array(
            'description' => 'Stores email for newsletter.',
            'fields' => array(
                'id' => array(
                    'type' => 'serial',
                    'not null' => TRUE,
                    'description' => 'Primary Key: Unique email ID.',
                ),
                'created_at' => array(
                    'type' => 'varchar',
                    'length' => 100,
                    'mysql_type' => 'datetime',
                    'not null' => TRUE,
                ),
                'updated_at' => array(
                    'type' => 'varchar',
                    'length' => 100,
                    'mysql_type' => 'datetime',
                    'not null' => TRUE,
                ),
                'email' => array(
                    'type' => 'varchar',
                    'length' => 255,
                    'not null' => TRUE,
                    'default' => '',
                    'description' => 'Email of the person.',
                ),
                'active' => array(
                    'type' => 'int',
                    'length' => 11,
                    'not null' => TRUE,
                    'default' => '0',
                    'description' => 'Active subscription of the person.',
                ),
                'exported' => array(
                    'type' => 'int',
                    'size' => 'tiny',
                    'not null' => TRUE,
                    'default' => '0',
                    'description' => '',
                ),
            ),
            'primary key' => array('id'),
            'indexes' => array(
                'email' => array('email'),
                'exported' => array('exported'),
            ),
        );

        return $array;
    }

    public function setSchemaTableSubscription()
    {
        $array = array(
            'description' => 'Stores email for newsletter.',
            'fields' => array(
                'id' => array(
                    'type' => 'serial',
                    'not null' => TRUE,
                    'description' => 'Primary Key: Unique email ID.',
                ),
                'id_subscriber' => array(
                    'type' => 'int',
                    'length' => 11,
                    'not null' => TRUE,
                    'description' => 'Subscriber ID.',
                ),
                'sema_design' => array(
                    'type' => 'int',
                    'size' => 'tiny',
                    'not null' => TRUE,
                    'default' => '0',
                    'description' => '',
                ),
                'comptoir_de_famille' => array(
                    'type' => 'int',
                    'size' => 'tiny',
                    'not null' => TRUE,
                    'default' => '0',
                    'description' => '',
                ),
                'cote_table' => array(
                    'type' => 'int',
                    'size' => 'tiny',
                    'not null' => TRUE,
                    'default' => '0',
                    'description' => '',
                ),
                'genevieve_lethu' => array(
                    'type' => 'int',
                    'size' => 'tiny',
                    'not null' => TRUE,
                    'default' => '0',
                    'description' => '',
                ),
                'jardin_d_ulysse' => array(
                    'type' => 'int',
                    'size' => 'tiny',
                    'not null' => TRUE,
                    'default' => '0',
                    'description' => '',
                )
            ),
            'primary key' => array('id')
        );

        return $array;
    }

    /************
     * DATABASE
     ************/
    private function getPeople($email)
    {
        $people = $this->connection->select($this->tableSubscriber,'subscriber')
            ->fields('subscriber')
            ->condition('subscriber.email', $email,'=')
            ->range(0, 1)
            ->execute()
            ->fetchAssoc();

        return $people;
    }


    private function insertPeople($arrayData)
    {
        $date = new DrupalDateTime();
        $this->connection->insert($this->tableSubscriber)
            ->fields([
                "email" => $arrayData['email'],
                "created_at" => $date->format("Y-m-d H:i:s"),
                "updated_at" => $date->format("Y-m-d H:i:s"),
                "active" => $arrayData['active'],
                "exported" => $arrayData['exported']
            ])
            ->execute();

        $people = $this->getPeople($arrayData['email']);
        $idPeople = $people['id'];

        $this->connection->insert($this->tableSubscription)
            ->fields([
                "id_subscriber" => intval($idPeople),
                "cote_table" => $arrayData['brands']["cote_table"],
                "comptoir_de_famille" => $arrayData['brands']["comptoir_de_famille"],
                "jardin_d_ulysse" => $arrayData['brands']["jardin_d_ulysse"],
                "genevieve_lethu" => $arrayData['brands']["genevieve_lethu"],
                "sema_design" => $arrayData['brands']["sema_design"]
            ])
            ->execute();
    }


    private function updatePeople($arrayData)
    {
        $date = new DrupalDateTime();
        $updatePeople = $this->connection->update($this->tableSubscriber)
            ->fields([
                "updated_at" => $date->format("Y-m-d H:i:s"),
                "active" => $arrayData['active']
            ])
            ->condition('email', $arrayData['email'], '=')
            ->execute();

        $people = $this->getPeople($arrayData['email']);
        $idPeople = $people['id'];

        $updatePeople = $this->connection->update($this->tableSubscription)
            ->fields([
                'cote_table' => $arrayData['brands']['cote_table'],
                'comptoir_de_famille' => $arrayData['brands']['comptoir_de_famille'],
                'jardin_d_ulysse' => $arrayData['brands']['jardin_d_ulysse'],
                'genevieve_lethu' => $arrayData['brands']['genevieve_lethu'],
                'sema_design' => $arrayData['brands']['sema_design']
            ])
            ->condition('id_subscriber', intval($idPeople), '=')
            ->execute();
    }
}