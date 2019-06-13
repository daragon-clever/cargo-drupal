<?php

namespace Drupal\newsletter\Controller\Company;


use Drupal\Core\Datetime\DrupalDateTime;
use Drupal\newsletter\Controller\AbstractCompanyController;

class ComptoirDeFamilleController extends AbstractCompanyController
{
    const ENTITY_ACTITO = "Yliades";
    const TABLE_ACTITO = "Yliades";

    protected function getPeople(string $email): ?array
    {
        $people = $this->connection->select(self::TABLE_SUBSCRIBER,'subscriber')
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
        $this->connection->insert(self::TABLE_SUBSCRIBER)
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
        if (isset($arrayData['active'])) $fields['active'] = $arrayData['active'];
        if (isset($arrayData['exported'])) $fields['exported'] = $arrayData['exported'];

        $this->connection->update(self::TABLE_SUBSCRIBER)
            ->fields($fields)
            ->condition('email', $arrayData['email'], '=')
            ->execute();
    }

    public function savePeopleInActito(array $dataUser): void
    {
        $dataForActito = [
            'email' => $dataUser['email'],
            'source' => "comptoir-de-famille",
            'segment' => "comptoir_de_famille"
        ];

        $searchUser = $this->getPeople($dataForActito['email']);
        $contactIdToUse = intval($searchUser['id']);
        $contactId = str_pad($contactIdToUse, 6, "0", STR_PAD_LEFT);

        $dataForActito['contact_id'] = "CDF_".strval($contactId);
        parent::savePeopleInActito($dataForActito);
    }
}