<?php

namespace Drupal\newsletter\Profile;

class SitramProfile extends BaseProfile
{
    protected function addDataOnSubscriberBeforeInsert(array $dataReceived)
    {
        return $this->subscriberDataForInsertOrUpdate($dataReceived);
    }

    protected function addDataOnSubscriberBeforeUpdate(array $dataReceived)
    {
        return $this->subscriberDataForInsertOrUpdate($dataReceived);
    }

    private function subscriberDataForInsertOrUpdate(array $dataReceived)
    {
        $return['first_name'] = $dataReceived['prenom'];
        $return['last_name'] = $dataReceived['nom'];

        return $return;
    }
}