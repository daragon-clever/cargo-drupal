<?php

namespace Drupal\newsletter\Controller\Company;


use Drupal\Core\Datetime\DrupalDateTime;
use Drupal\newsletter\Controller\AbstractCompanyController;

class BlogSitramController extends AbstractCompanyController
{
    const ENTITY_ACTITO = "GersEquipement";
    const TABLE_ACTITO = "GersEquipement";

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
        $email = $dataUser['email'];

        $searchUser = $this->getPeople($email);

        $contactIdToUse = intval($searchUser['id']);
        $contactId = str_pad($contactIdToUse, 6, "0", STR_PAD_LEFT);

        $dataForActito = array(
            'email' => $email,
            'contact_id' => "BLG-SIT_".strval($contactId),
            'source' => "blog_sitram"
        );
        parent::savePeopleInActito($dataForActito);
    }
}