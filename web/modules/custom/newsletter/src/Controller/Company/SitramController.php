<?php

namespace Drupal\newsletter\Controller\Company;


use Drupal\newsletter\Controller\AbstractCompanyController;

class SitramController extends AbstractCompanyController
{
    const ENTITY_ACTITO = "GersEquipement";
    const TABLE_ACTITO = "GersEquipement";

    protected function setDataToInsertPeopleOnDb($arrayData): array
    {
        $dataToInsert = parent::setDataToInsertPeopleOnDb($arrayData);
        $additionalData = $this->setDataToInsertOrUpdatePeopleOnDb($arrayData);
        return array_merge($dataToInsert, $additionalData);
    }

    protected function setDataToUpdatePeopleOnDb($arrayData): array
    {
        $dataToUpdate = parent::setDataToUpdatePeopleOnDb($arrayData);
        $additionalData = $this->setDataToInsertOrUpdatePeopleOnDb($arrayData);
        return array_merge($dataToUpdate, $additionalData);
    }

    public function setDataToSaveOnActito(array $dataUser): array
    {
        $dataForActito = parent::setDataToSaveOnActito($dataUser);
        $dataForActito['first_name'] = $dataUser['prenom'];
        $dataForActito['last_name'] = $dataUser['nom'];
        $dataForActito['source'] = "site-sitram";
        $dataForActito['newsletter'] = "1";

        return $dataForActito;
    }

    private function setDataToInsertOrUpdatePeopleOnDb($arrayData): array
    {
        $dataToUpdate['first_name'] = $arrayData['prenom'];
        $dataToUpdate['last_name'] = $arrayData['nom'];

        return $dataToUpdate;
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
            ]
        ];
        $array['fields'] = array_merge($array['fields'], $arrayPushData);

        return $array;
    }
}