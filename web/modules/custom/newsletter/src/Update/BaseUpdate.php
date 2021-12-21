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
}