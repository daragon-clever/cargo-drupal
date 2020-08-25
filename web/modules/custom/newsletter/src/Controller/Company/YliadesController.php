<?php

namespace Drupal\newsletter\Controller\Company;


use Drupal\newsletter\Controller\AbstractCompanyController;

class YliadesController extends AbstractCompanyController
{
    const ENTITY_ACTITO = "Yliades";
    const TABLE_ACTITO = "Yliades";

    const MARQUE_ALL = "toutes_les_marques";
    const MARQUE_SEMA_DESIGN = "sema_design";
    const MARQUE_COMPTOIR_DE_FAMILLE = "comptoir_de_famille";
    const MARQUE_COTE_TABLE = "cote_table";
    const MARQUE_GENEVIEVE_LETHU = "genevieve_lethu";
    const MARQUE_JARDIN_D_ULYSSE = "jardin_d_ulysse";
    const MARQUE_NATIVES = "natives";
    const LES_MARQUES = [
        self::MARQUE_ALL, self::MARQUE_SEMA_DESIGN, self::MARQUE_COMPTOIR_DE_FAMILLE,
        self::MARQUE_COTE_TABLE, self::MARQUE_GENEVIEVE_LETHU, self::MARQUE_JARDIN_D_ULYSSE,
        self::MARQUE_NATIVES
    ];

    protected function updatePeople(array $arrayData): void
    {
        $dataToUpdate = $this->setDataToUpdatePeopleOnDb($arrayData);
        $this->subscriberModel->updateSubscriber($arrayData['email'], $dataToUpdate);
        $this->deleteSegmentInActito($arrayData);
    }


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

    protected function setDataToInsertOrUpdatePeopleOnDb($arrayData): array
    {
        return [
            'subscriptions' => serialize([
                "cote_table" => $arrayData['brands'][self::MARQUE_COTE_TABLE],
                "comptoir_de_famille" => $arrayData['brands'][self::MARQUE_COMPTOIR_DE_FAMILLE],
                "jardin_d_ulysse" => $arrayData['brands'][self::MARQUE_JARDIN_D_ULYSSE],
                "genevieve_lethu" => $arrayData['brands'][self::MARQUE_GENEVIEVE_LETHU],
                "sema_design" => $arrayData['brands'][self::MARQUE_SEMA_DESIGN],
                "natives" => $arrayData['brands'][self::MARQUE_NATIVES]
            ])
        ];
    }

    public function setDataToSaveOnActito(array $dataUser): array
    {
        $dataForActito = parent::setDataToSaveOnActito($dataUser);
        $dataForActito['source'] = "yliades";
        unset($dataUser['brands'][self::MARQUE_ALL]);
        $dataForActito['segment'] = array_keys(array_diff( $dataUser['brands'], [0] )); //Remove brands with subscribe value at 0/false;

        return $dataForActito;
    }

    public function deleteSegmentInActito(array $dataUser): void
    {
        unset($dataUser['brands'][self::MARQUE_ALL]);
        $segmentsToDel =  array_keys(array_diff( $dataUser['brands'], [1] ));

        foreach ($segmentsToDel as $segment) {
            $dataForActito = [
                "segment" => $segment,
                "email" => $dataUser['email']
            ];

            parent::deleteSegmentInActito($dataForActito);
        }
    }

    public function setSchemaTableSubscriber(): array
    {
        $array = parent::setSchemaTableSubscriber();
        $arrayPushData = [
            'subscriptions' => [
                'type' => 'text',
                'size' => 'big',
                'description' => 'Subscriptions list of subscriber',
            ]
        ];
        $array['fields'] = array_merge($array['fields'], $arrayPushData);

        return $array;
    }

    public function setUpdate8101($oldTableName)
    {
        $newColumn = "subscriptions";

        //add new collumn
        $spec = [
            'type' => 'text',
            'size' => 'big',
            'description' => 'Subscriptions list of subscriber',
        ];
        $schema = \Drupal::database()->schema();
        $schemaFieldExist = $schema->fieldExists($this->subscriberModel::TABLE_SUBSCRIBER, $newColumn);
        if (!$schemaFieldExist) $schema->addField($this->subscriberModel::TABLE_SUBSCRIBER, $newColumn, $spec);

        //move data in new collumn
        $connection = \Drupal::database();

        $dataSubscriptions = $connection->select($oldTableName,'subscriptions')
            ->fields('subscriptions')
            ->execute()
            ->fetchAll();

        foreach ($dataSubscriptions as $val) {
            $fields[$newColumn] = serialize([
                self::MARQUE_SEMA_DESIGN => $val->{self::MARQUE_SEMA_DESIGN},
                self::MARQUE_COMPTOIR_DE_FAMILLE => $val->{self::MARQUE_COMPTOIR_DE_FAMILLE},
                self::MARQUE_COTE_TABLE => $val->{self::MARQUE_COTE_TABLE},
                self::MARQUE_GENEVIEVE_LETHU => $val->{self::MARQUE_GENEVIEVE_LETHU},
                self::MARQUE_JARDIN_D_ULYSSE => $val->{self::MARQUE_JARDIN_D_ULYSSE},
                self::MARQUE_NATIVES => $val->{self::MARQUE_NATIVES},
            ]);
            $idSubscriber = $val->id_subscriber;

            $connection->update($this->subscriberModel::TABLE_SUBSCRIBER)
                ->fields($fields)
                ->condition('id', $idSubscriber, '=')
                ->execute();
        }
    }
}