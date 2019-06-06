<?php

namespace Drupal\newsletter\Controller\Company;


use Drupal\Core\Datetime\DrupalDateTime;
use Drupal\newsletter\Controller\NewsletterController;

class BlogSitramController extends NewsletterController
{

    public function doAction($arrayData)
    {
        $people = $this->getPeople($arrayData['email']);

        if (empty($people)) {
            $this->insertPeople($arrayData);
            $action = self::ACTION_INSERT;
        } else {
            $this->updatePeople($arrayData);
            $action = self::ACTION_UPDATE;
        }

        return $this->displayMsg($action);
    }



    /************
     * DATABASE
     ************/
    public function getPeople($email)
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
    }


    private function updatePeople($arrayData)
    {
        $date = new DrupalDateTime();
        $this->connection->update($this->tableSubscriber)
            ->fields([
                "updated_at" => $date->format("Y-m-d H:i:s"),
                "active" => $arrayData['active']
            ])
            ->condition('email', $arrayData['email'], '=')
            ->execute();
    }
}