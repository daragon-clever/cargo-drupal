<?php

namespace Drupal\newsletter\Update;

use Drupal\newsletter\NewsletterSubscriberRepository;
use Drupal\newsletter\Profile\CestDeuxEurosProfile;

class CestDeuxEurosUpdate extends BaseUpdate
{
    public function setUpdate($version)
    {
        parent::setUpdate($version);

        switch ($version) {
            case '8102':
                $this->setUpdate8102();
                break;
            case '8104':
                $this->setUpdate8104();
                break;
        }
    }

    public function setUpdate8101($oldTableName)
    {
        \Drupal::logger('newsletter')->notice('[UPDATE] Déplacement des données de la table '.$oldTableName
            .' dans la nouvelle colonne subscriptions de la table newsletter_susbcriber');

        $connection = \Drupal::database();
        $newColumn = "subscriptions";

        //add new collumn
        $spec = [
            'type' => 'text',
            'size' => 'big',
            'description' => 'Subscriptions list of subscriber',
        ];
        $schema = $connection->schema();
        $schemaFieldExist = $schema->fieldExists(NewsletterSubscriberRepository::TABLE_NAME, $newColumn);
        if (!$schemaFieldExist) $schema->addField(NewsletterSubscriberRepository::TABLE_NAME, $newColumn, $spec);

        //move data in new collumn
        $dataSubscriptions = $connection->select($oldTableName,'subscriptions')
            ->fields('subscriptions')
            ->execute()
            ->fetchAll();
        foreach ($dataSubscriptions as $val) {
            $fields[$newColumn] = serialize([
                CestDeuxEurosProfile::SUBSCRIPTION_NEWSLETTER => $val->{CestDeuxEurosProfile::SUBSCRIPTION_NEWSLETTER},
                CestDeuxEurosProfile::SUBSCRIPTION_OFFER => $val->{CestDeuxEurosProfile::SUBSCRIPTION_OFFER},
            ]);
            $idSubscriber = $val->id_subscriber;
            $connection->update(NewsletterSubscriberRepository::TABLE_NAME)
                ->fields($fields)
                ->condition('id', $idSubscriber, '=')
                ->execute();
        }

        \Drupal::logger('newsletter')->notice('[UPDATE] Succès');

        parent::setUpdate8101($oldTableName);
    }

    private function setUpdate8102()
    {
        \Drupal::logger('newsletter')->notice('[UPDATE] Ajout colonne pour le n° de mobile');

        $connection = \Drupal::database();
        if ($connection->schema()->tableExists(NewsletterSubscriberRepository::TABLE_NAME)) {
            $newColumn = "mobile";

            //add new collumn
            $spec = [
                'type' => 'varchar',
                'length' => 50,
                'not null' => TRUE,
                'default' => '',
                'description' => 'Mobile phone of the person.',
            ];
            $schema = $connection->schema();
            $schemaFieldExist = $schema->fieldExists(NewsletterSubscriberRepository::TABLE_NAME, $newColumn);
            if (!$schemaFieldExist) $schema->addField(NewsletterSubscriberRepository::TABLE_NAME, $newColumn, $spec);
        }

        \Drupal::logger('newsletter')->notice('[UPDATE] Succès');
    }

    private function setUpdate8104()
    {
        \Drupal::logger('newsletter')->notice('[UPDATE] Suppression de la colonne abonnement qui n\'est plus utilisée');

        $connection = \Drupal::database();
        if ($connection->schema()->tableExists(NewsletterSubscriberRepository::TABLE_NAME)) {
            $oldColumn = "subscriptions";
            $schema = $connection->schema();
            $schemaFieldExist = $schema->fieldExists(NewsletterSubscriberRepository::TABLE_NAME, $oldColumn);
            if ($schemaFieldExist) $schema->dropField(NewsletterSubscriberRepository::TABLE_NAME, $oldColumn);
        }

        \Drupal::logger('newsletter')->notice('[UPDATE] Succès');
    }
}