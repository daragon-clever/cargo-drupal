<?php

namespace Drupal\newsletter\Controller\Company;


use Drupal\Core\Datetime\DrupalDateTime;
use Drupal\newsletter\Controller\NewsletterController;

class YliadesController extends NewsletterController
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

    public function doAction(array $arrayData): array
    {
        $marques = $this->setValueAllBrands(0);//get array with all brands (value -> 0)

        foreach ($arrayData['brands'] as $key => $value) {
            if (is_string($value)) {
                if ($value == self::MARQUE_ALL && $key == self::MARQUE_ALL) {
                    $marques = $this->setValueAllBrands(1);
                    break;
                } else {
                    $marques[$value] = 1;
                }
            }
        }
        $arrayData['brands'] = $marques;

        return parent::doAction($arrayData);
    }

    private function setValueAllBrands(int $val): array
    {
        $newArray = array_fill_keys(self::LES_MARQUES, $val);
        return $newArray;
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

        $people = $this->getPeople($arrayData['email']);
        $idPeople = $people['id'];

        $this->connection->insert($this->tableSubscription)
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
        $date = new DrupalDateTime();
        $this->connection->update($this->tableSubscriber)
            ->fields([
                "updated_at" => $date->format("Y-m-d H:i:s"),
                "active" => $arrayData['active']
            ])
            ->condition('email', $arrayData['email'], '=')
            ->execute();

        $people = $this->getPeople($arrayData['email']);
        $idPeople = $people['id'];

        $this->connection->update($this->tableSubscription)
            ->fields([
                'cote_table' => $arrayData['brands'][self::MARQUE_COTE_TABLE],
                'comptoir_de_famille' => $arrayData['brands'][self::MARQUE_COMPTOIR_DE_FAMILLE],
                'jardin_d_ulysse' => $arrayData['brands'][self::MARQUE_JARDIN_D_ULYSSE],
                'genevieve_lethu' => $arrayData['brands'][self::MARQUE_GENEVIEVE_LETHU],
                'sema_design' => $arrayData['brands'][self::MARQUE_SEMA_DESIGN]
            ])
            ->condition('id_subscriber', intval($idPeople), '=')
            ->execute();
    }

    public function setSchemaTableSubscription(): array
    {
        $array = parent::setSchemaTableSubscription();
        $arrayPushData = array(
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
        );
        $array['field'] = array_merge($array['field'], $arrayPushData);

        return $array;
    }
}