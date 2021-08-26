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
}