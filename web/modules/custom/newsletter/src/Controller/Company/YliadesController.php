<?php

namespace Drupal\newsletter\Controller\Company;


use Drupal\Core\Datetime\DrupalDateTime;
use Drupal\newsletter\Controller\AbstractCompanyController;

class YliadesController extends AbstractCompanyController
{
    const MARQUE_ALL = "toutes_les_marques";
    const MARQUE_SEMA_DESIGN = "sema_design";
    const MARQUE_COMPTOIR_DE_FAMILLE = "comptoir_de_famille";
    const MARQUE_COTE_TABLE = "cote_table";
    const MARQUE_GENEVIEVE_LETHU = "genevieve_lethu";
    const MARQUE_JARDIN_D_ULYSSE = "jardin_d_ulysse";
    const LES_MARQUES = [
        self::MARQUE_ALL, self::MARQUE_SEMA_DESIGN, self::MARQUE_COMPTOIR_DE_FAMILLE,
        self::MARQUE_COTE_TABLE, self::MARQUE_GENEVIEVE_LETHU, self::MARQUE_JARDIN_D_ULYSSE
    ];
    const ENTITY_ACTITO = "Yliades";
    const TABLE_ACTITO = "Yliades";

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

        $people = $this->getPeople($arrayData['email']);
        $idPeople = $people['id'];

        $this->connection->insert(self::TABLE_SUBSCRIBTION)
            ->fields([
                "id_subscriber" => intval($idPeople),
                "cote_table" => $arrayData['brands'][self::MARQUE_COTE_TABLE],
                "comptoir_de_famille" => $arrayData['brands'][self::MARQUE_COMPTOIR_DE_FAMILLE],
                "jardin_d_ulysse" => $arrayData['brands'][self::MARQUE_JARDIN_D_ULYSSE],
                "genevieve_lethu" => $arrayData['brands'][self::MARQUE_GENEVIEVE_LETHU],
                "sema_design" => $arrayData['brands'][self::MARQUE_SEMA_DESIGN]
            ])
            ->execute();
    }

    protected function updatePeople(array $arrayData): void
    {
        $people = $this->getPeople($arrayData['email']);

        $date = new DrupalDateTime();
        //Define the fields for the update
        $fields["updated_at"] = $date->format("Y-m-d H:i:s");
        if (isset($arrayData['active'])) $fields['active'] = $arrayData['active'];
        if (isset($arrayData['exported'])) $fields['exported'] = $arrayData['exported'];

        //Update table subscriber
        $this->connection->update(self::TABLE_SUBSCRIBER)
            ->fields($fields)
            ->condition('email', $arrayData['email'], '=')
            ->execute();

        //Update table subscription
        if (isset($arrayData['brands'])) {
            $this->connection->update(self::TABLE_SUBSCRIBTION)
                ->fields([
                    'cote_table' => $arrayData['brands'][self::MARQUE_COTE_TABLE],
                    'comptoir_de_famille' => $arrayData['brands'][self::MARQUE_COMPTOIR_DE_FAMILLE],
                    'jardin_d_ulysse' => $arrayData['brands'][self::MARQUE_JARDIN_D_ULYSSE],
                    'genevieve_lethu' => $arrayData['brands'][self::MARQUE_GENEVIEVE_LETHU],
                    'sema_design' => $arrayData['brands'][self::MARQUE_SEMA_DESIGN]
                ])
                ->condition('id_subscriber', intval($people["id"]), '=')
                ->execute();
        }
    }

    public function savePeopleInActito(array $dataUser): void
    {
        $dataForActito = [
            'email' => $dataUser['email'],
            'source' => "yliades",
            'segment' => array_keys(array_diff( $dataUser['brands'], [0] )) //Remove brands with subscribe value at 0/false
        ];

        parent::savePeopleInActito($dataForActito);
    }

    public function setSchemaTableSubscription(): array
    {
        $array = parent::setSchemaTableSubscription();
        $arrayPushData = [
            'sema_design' => [
                'type' => 'int',
                'size' => 'tiny',
                'not null' => TRUE,
                'default' => '0',
                'description' => '',
            ],
            'comptoir_de_famille' => [
                'type' => 'int',
                'size' => 'tiny',
                'not null' => TRUE,
                'default' => '0',
                'description' => '',
            ],
            'cote_table' => [
                'type' => 'int',
                'size' => 'tiny',
                'not null' => TRUE,
                'default' => '0',
                'description' => '',
            ],
            'genevieve_lethu' => [
                'type' => 'int',
                'size' => 'tiny',
                'not null' => TRUE,
                'default' => '0',
                'description' => '',
            ],
            'jardin_d_ulysse' => [
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