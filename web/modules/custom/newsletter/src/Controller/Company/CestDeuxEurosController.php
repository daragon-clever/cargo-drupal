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

    const SUBSCRIPTION_NEWSLETTER = "newsletter_shop";
    const SUBSCRIPTION_OFFER = "offers";

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
        $dataForActito['prenom'] = $dataUser['prenom'];
        $dataForActito['nom'] = $dataUser['nom'];
        $dataForActito['cp'] = $dataUser['cp'];
        $dataForActito['newsletter'] = $dataUser['newsletter'];
        $dataForActito['offres'] = $dataUser['offres'];

        return $dataForActito;
    }

    private function setDataToInsertOrUpdatePeopleOnDb($arrayData): array
    {
        $dataToUpdate['first_name'] = $arrayData['prenom'];
        $dataToUpdate['last_name'] = $arrayData['nom'];
        $dataToUpdate['zip_code'] = $arrayData['cp'];
        $dataToUpdate['subscriptions'] = serialize([
            self::SUBSCRIPTION_NEWSLETTER => $arrayData['newsletter'],
            self::SUBSCRIPTION_OFFER => $arrayData['offres']
        ]);

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
            ],
            'zip_code' => [
                'type' => 'varchar',
                'length' => 10,
                'not null' => TRUE,
                'default' => '',
                'description' => 'Postcode of the person.',
            ],
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
                self::SUBSCRIPTION_NEWSLETTER => $val->{self::SUBSCRIPTION_NEWSLETTER},
                self::SUBSCRIPTION_OFFER => $val->{self::SUBSCRIPTION_OFFER},
            ]);
            $idSubscriber = $val->id_subscriber;

            $connection->update($this->subscriberModel::TABLE_SUBSCRIBER)
                ->fields($fields)
                ->condition('id', $idSubscriber, '=')
                ->execute();
        }
    }
}