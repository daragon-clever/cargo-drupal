<?php

namespace Drupal\newsletter\Update;

use Drupal\newsletter\NewsletterSubscriberRepository;
use Drupal\newsletter\Profile\YliadesProfile;

class YliadesUpdate extends BaseUpdate
{
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
                YliadesProfile::MARQUE_SEMA_DESIGN => $val->{YliadesProfile::MARQUE_SEMA_DESIGN},
                YliadesProfile::MARQUE_COMPTOIR_DE_FAMILLE => $val->{YliadesProfile::MARQUE_COMPTOIR_DE_FAMILLE},
                YliadesProfile::MARQUE_COTE_TABLE => $val->{YliadesProfile::MARQUE_COTE_TABLE},
                YliadesProfile::MARQUE_GENEVIEVE_LETHU => $val->{YliadesProfile::MARQUE_GENEVIEVE_LETHU},
                YliadesProfile::MARQUE_JARDIN_D_ULYSSE => $val->{YliadesProfile::MARQUE_JARDIN_D_ULYSSE},
                YliadesProfile::MARQUE_NATIVES => $val->{YliadesProfile::MARQUE_NATIVES},
            ]);
            $idSubscriber = $val->id_subscriber;
            $connection->update(NewsletterSubscriberRepository::TABLE_NAME)
                ->fields($fields)
                ->condition('id', $idSubscriber, '=')
                ->execute();
        }

        \Drupal::logger('newsletter')->notice('[UPDATE] Succès');
    }
}