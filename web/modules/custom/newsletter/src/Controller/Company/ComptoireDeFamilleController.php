<?php

namespace Drupal\newsletter\Controller\Company;


use Drupal\Core\Datetime\DrupalDateTime;
use Drupal\newsletter\Controller\NewsletterController;

class ComptoireDeFamilleController extends NewsletterController
{
    public function __construct()
    {
        NewsletterController::__construct();
    }

    public function doAction($arrayData)
    {
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
            'description' => 'Stores subscription for newsletter subscriber.',
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
                'subscription' => array(
                    'type' => 'varchar',
                    'length' => 255,
                    'not null' => FALSE
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
        $insertPeople = $this->connection->insert($this->tableSubscriber)
            ->fields([
                "email" => $arrayData['email'],
                "created_at" => $date->format("Y-m-d H:i:s"),
                "updated_at" => $date->format("Y-m-d H:i:s"),
                "active" => $arrayData['active'],
                "exported" => $arrayData['exported']
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
    }
}