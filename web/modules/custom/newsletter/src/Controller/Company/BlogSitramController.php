<?php

namespace Drupal\newsletter\Controller\Company;


use Drupal\newsletter\Controller\AbstractCompanyController;

class BlogSitramController extends AbstractCompanyController
{
    const ENTITY_ACTITO = "GersEquipement";
    const TABLE_ACTITO = "GersEquipement";

    public function savePeopleInActito(array $dataUser): void
    {
        $dataForActito = array(
            'email' => $dataUser['email'],
            'source' => "blog-sitram",
            'newsletter' => "1"
        );
        parent::savePeopleInActito($dataForActito);
    }
}