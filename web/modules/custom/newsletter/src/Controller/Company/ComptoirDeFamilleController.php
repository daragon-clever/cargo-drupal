<?php

namespace Drupal\newsletter\Controller\Company;


use Drupal\Core\Datetime\DrupalDateTime;
use Drupal\newsletter\Controller\AbstractCompanyController;

class ComptoirDeFamilleController extends AbstractCompanyController
{
    public function doAction(array $arrayData): array
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

    public function getPeople(string $email): ?array
    {
        $people = $this->connection->select($this->tableSubscriber,'subscriber')
            ->fields('subscriber')
            ->condition('subscriber.email', $email,'=')
            ->range(0, 1)
            ->execute()
            ->fetchAssoc();

        return $people ? $people : null;
    }

    protected function insertPeople(array $arrayData): void
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


    protected function updatePeople(array $arrayData): void
    {
        $date = new DrupalDateTime();
        $fields["updated_at"] = $date->format("Y-m-d H:i:s");
        if (isset($arrayData['active'])) $fields['exported'] = $arrayData['active'];
        if (isset($arrayData['exported'])) $fields['exported'] = $arrayData['exported'];

        $this->connection->update($this->tableSubscriber)
            ->fields($fields)
            ->condition('email', $arrayData['email'], '=')
            ->execute();
    }
}