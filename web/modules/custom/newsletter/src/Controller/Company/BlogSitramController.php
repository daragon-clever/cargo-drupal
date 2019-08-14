<?php

namespace Drupal\newsletter\Controller\Company;


use Drupal\Core\Database\Database;
use Drupal\Core\Datetime\DrupalDateTime;
use Drupal\newsletter\Controller\AbstractCompanyController;

class BlogSitramController extends AbstractCompanyController
{
    const ENTITY_ACTITO = "GersEquipement";
    const TABLE_ACTITO = "GersEquipement";

    public function doAction(array $dataPeople): array
    {
        $return = parent::doAction($dataPeople);

        $this->savePeopleInActito($dataPeople);

        return $return;
    }

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
        $this->connection->insert(self::TABLE_SUBSCRIBER)
            ->fields([
                "email" => $arrayData['email'],
                "created_at" => $this->date->format("Y-m-d H:i:s"),
                "updated_at" => $this->date->format("Y-m-d H:i:s"),
                "active" => $arrayData['active'],
                "exported" => $arrayData['exported']
            ])
            ->execute();
    }

    protected function updatePeople(array $arrayData): void
    {
        $people = $this->getPeople($arrayData['email']);

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
        $dataForActito = array(
            'email' => $dataUser['email'],
            'source' => "blog-sitram",
            'newsletter' => "1"
        );
        parent::savePeopleInActito($dataForActito);
    }

    public function setSchemaTableSubscriber(): array
    {
        $array = parent::setSchemaTableSubscriber();
        $arrayPushData = [
            'exported' => [
                'type' => 'int',
                'size' => 'tiny',
                'not null' => TRUE,
                'default' => '0',
                'description' => '',
            ]
        ];
        $array['fields'] = array_merge($array['fields'], $arrayPushData);

        return $array;
    }
}