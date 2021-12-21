<?php

namespace Drupal\newsletter\Profile;

class YliadesProfile extends BaseProfile
{
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
        $return['subscriptions'] = serialize([
            "cote_table" => $dataReceived['brands'][self::MARQUE_COTE_TABLE],
            "comptoir_de_famille" => $dataReceived['brands'][self::MARQUE_COMPTOIR_DE_FAMILLE],
            "jardin_d_ulysse" => $dataReceived['brands'][self::MARQUE_JARDIN_D_ULYSSE],
            "genevieve_lethu" => $dataReceived['brands'][self::MARQUE_GENEVIEVE_LETHU],
            "sema_design" => $dataReceived['brands'][self::MARQUE_SEMA_DESIGN],
            "natives" => $dataReceived['brands'][self::MARQUE_NATIVES]
        ]);

        return $return;
    }
}