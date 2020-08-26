<?php

namespace Drupal\newsletter\Controller\Company;


use Drupal\newsletter\Controller\AbstractCompanyController;

class ComptoirDeFamilleController extends AbstractCompanyController
{
    const ENTITY_ACTITO = "Yliades";
    const TABLE_ACTITO = "Yliades";

    public function setDataToSaveOnActito(array $dataUser): array
    {
        $dataForActito = parent::setDataToSaveOnActito($dataUser);
        $dataForActito['source'] = "comptoir-de-famille";
        $dataForActito['segment'] = "comptoir_de_famille";

        return $dataForActito;
    }
}