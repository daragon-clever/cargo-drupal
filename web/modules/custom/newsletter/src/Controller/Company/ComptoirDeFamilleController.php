<?php

namespace Drupal\newsletter\Controller\Company;


use Drupal\newsletter\Controller\AbstractCompanyController;

class ComptoirDeFamilleController extends AbstractCompanyController
{
    const ENTITY_ACTITO = "Yliades";
    const TABLE_ACTITO = "Yliades";

    public function savePeopleInActito(array $dataUser): void
    {
        $dataForActito = [
            'email' => $dataUser['email'],
            'source' => "comptoir-de-famille",
            'segment' => "comptoir_de_famille"
        ];

        parent::savePeopleInActito($dataForActito);
    }
}