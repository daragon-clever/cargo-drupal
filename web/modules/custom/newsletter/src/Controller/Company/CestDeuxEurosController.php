<?php
/**
 * Created by PhpStorm.
 * User: abe
 * Date: 26/08/2019
 * Time: 11:58
 */

namespace Drupal\newsletter\Controller\Company;


use Drupal\newsletter\Controller\AbstractCompanyController;

class CestDeuxEurosController extends AbstractCompanyController
{
    const ENTITY_ACTITO = "Cest2euros";
    const TABLE_ACTITO = "Cest2euros";

    protected function setDataToInsertPeople($arrayData): array
    {
        $dataToInsert = parent::setDataToInsertPeople($arrayData);

        $dataToInsert['first_name'] = $arrayData['prenom'];
        $dataToInsert['last_name'] = $arrayData['nom'];
        $dataToInsert['zip_code'] = $arrayData['cp'];

        return $dataToInsert;
    }

    protected function insertPeople(array $arrayData): void
    {
        parent::insertPeople($arrayData);

        $people = $this->getPeople($arrayData['email']);
        $idPeople = $people['id'];

        $this->connection->insert(self::TABLE_SUBSCRIBTION)
            ->fields([
                "id_subscriber" => intval($idPeople),
                "newsletter_shop" => $arrayData['newsletter'],
                "offers" => $arrayData['offres'],
            ])
            ->execute();
    }

    protected function setDataToUpdatePeople($arrayData): array
    {
        $dataToUpdate = parent::setDataToUpdatePeople($arrayData);

        $dataToUpdate['first_name'] = $arrayData['prenom'];
        $dataToUpdate['last_name'] = $arrayData['nom'];
        $dataToUpdate['zip_code'] = $arrayData['cp'];

        return $dataToUpdate;
    }

    protected function updatePeople(array $arrayData): void
    {
        parent::updatePeople($arrayData);

        $people = $this->getPeople($arrayData['email']);

        //Update table subscription
        if (isset($arrayData['newsletter']) && isset($arrayData['offres'])) {
            $this->connection->update(self::TABLE_SUBSCRIBTION)
                ->fields([
                    "newsletter_shop" => $arrayData['newsletter'],
                    "offers" => $arrayData['offres'],
                ])
                ->condition('id_subscriber', intval($people["id"]), '=')
                ->execute();
        }
    }

    public function savePeopleInActito(array $dataUser): void
    {
        $dataForActito = array(
            'prenom' => $dataUser['prenom'],
            'nom' => $dataUser['nom'],
            'cp' => $dataUser['cp'],
            'email' => $dataUser['email'],
            'newsletter' => $dataUser['newsletter'],
            'offres' => $dataUser['offres'],
        );
        parent::savePeopleInActito($dataForActito);
    }

    public function setSchemaTableSubscription(): array
    {
        $array = parent::setSchemaTableSubscription();
        $arrayPushData = [
            'newsletter_shop' => [
                'type' => 'int',
                'size' => 'tiny',
                'not null' => TRUE,
                'default' => '0',
                'description' => '',
            ],
            'offers' => [
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
            'first_name' => [
                'type' => 'varchar',
                'length' => 255,
                'not null' => TRUE,
                'default' => '',
                'description' => 'Firstname of the person.',
            ],
            'last_name' => [
                'type' => 'varchar',
                'length' => 255,
                'not null' => TRUE,
                'default' => '',
                'description' => 'Lastname of the person.',
            ],
            'zip_code' => [
                'type' => 'varchar',
                'length' => 10,
                'not null' => TRUE,
                'default' => '',
                'description' => 'Postcode of the person.',
            ]
        ];
        $array['fields'] = array_merge($array['fields'], $arrayPushData);

        return $array;
    }
}