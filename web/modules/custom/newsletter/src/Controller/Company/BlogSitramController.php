<?php

namespace Drupal\newsletter\Controller\Company;


use Drupal\newsletter\Controller\AbstractCompanyController;

class BlogSitramController extends AbstractCompanyController
{
    const ENTITY_ACTITO = "GersEquipement";
    const TABLE_ACTITO = "GersEquipement";

    public function setDataToSaveOnActito(array $dataUser): array
    {
        $dataForActito = parent::setDataToSaveOnActito($dataUser);
        $dataForActito['source'] = "blog-sitram";
        $dataForActito['newsletter'] = "1";

        return $dataForActito;
    }
}