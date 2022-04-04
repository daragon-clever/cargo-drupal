<?php

namespace Drupal\newsletter\Update;

use Drupal\newsletter\NewsletterSubscriberRepository;

class BaseUpdate
{
    public function setUpdate($version)
    {
        switch ($version) {
            case '8101':
                $tableToDelete = "newsletter_subscription";
                $this->setUpdate8101($tableToDelete);
                break;
            case '8103':
                $this->setUpdate8103();
                break;
        }
    }

    public function setUpdate8101($tableToDelete)
    {
        if (\Drupal::database()->schema()->tableExists($tableToDelete)) {
            \Drupal::database()->schema()->dropTable($tableToDelete);
            \Drupal::logger('newsletter')->notice("[UPDATE] Suppression de l'ancienne table " . $tableToDelete);
        }
    }

    public function setUpdate8103()
    {
        if (\Drupal::database()->schema()->tableExists(NewsletterSubscriberRepository::TABLE_NAME)) {
            $oldField = "exported";
            \Drupal::database()->schema()->dropField(NewsletterSubscriberRepository::TABLE_NAME, $oldField);
            \Drupal::logger('newsletter')->notice("[UPDATE] Suppression de l'ancien champ : " . $oldField);
        }
    }

    /**
     * Only for Sema & Côté Table
     */
    protected function setUpdate8105()
    {
        $newColumn = "is_pro";
        \Drupal::logger('newsletter')->notice("[UPDATE] Ajout d'une nouvelle colonne " . $newColumn
            . ' dans la table newsletter_susbcriber');

        $connection = \Drupal::database();
        $schema = $connection->schema();

        //add new collumn
        $spec = [
            'type' => 'int',
            'length' => 11,
            'not null' => TRUE,
            'default' => '0',
            'description' => 'Is a pro person',
        ];
        $schemaFieldExist = $schema->fieldExists(NewsletterSubscriberRepository::TABLE_NAME, $newColumn);
        if (!$schemaFieldExist) $schema->addField(NewsletterSubscriberRepository::TABLE_NAME, $newColumn, $spec);

        \Drupal::logger('newsletter')->notice('[UPDATE] Succès');
    }
}