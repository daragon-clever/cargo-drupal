<?php

namespace Drupal\newsletter\Controller\Company;


use Drupal\Core\Database\Database;
use Drupal\Core\Datetime\DrupalDateTime;
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

    public function setSchemaTableSubscriber(): array
    {
        $array = parent::setSchemaTableSubscriber();
        $arrayPushData = [
            'exported' => [
                'type' => 'int',
                'size' => 'tiny',
                'not null' => TRUE,
                'default' => '0',
                'description' => '',
            ]
        ];
        $array['fields'] = array_merge($array['fields'], $arrayPushData);

        return $array;
    }
}