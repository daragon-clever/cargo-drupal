<?php

namespace Drupal\newsletter\Profile;

class CoteTableProfile extends BaseProfile
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
        $return['is_pro'] = $dataReceived['is_pro'];

        return $return;
    }
}