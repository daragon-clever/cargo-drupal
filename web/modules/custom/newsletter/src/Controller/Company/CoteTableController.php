<?php

namespace Drupal\newsletter\Controller\Company;


use Drupal\newsletter\Controller\AbstractCompanyController;

class CoteTableController extends AbstractCompanyController
{
    const ENTITY_ACTITO = "Yliades";
    const TABLE_ACTITO = "Yliades";

    public function setDataToSaveOnActito(array $dataUser): array
    {
        $dataForActito = parent::setDataToSaveOnActito($dataUser);
        $dataForActito['source'] = "cote-table";
        $dataForActito['segment'] = "cote_table";

        return $dataForActito;
    }

    protected function displayMsg(string $return): array
    {
        $displayMsgReturn = parent::displayMsg($return);

        if ($return == parent::ACTION_INSERT) {
            $displayMsgReturn['msg'] = $this->t("Thank you for subscribing to the newsletter");
        }

        return $displayMsgReturn;
    }
}