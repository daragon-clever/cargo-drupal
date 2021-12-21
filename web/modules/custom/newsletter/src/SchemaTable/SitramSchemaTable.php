<?php

namespace Drupal\newsletter\SchemaTable;

class SitramSchemaTable extends BaseSchemaTable
{
    public function createNewsletterSubscriberSchemaTable(): array
    {
        $tableSchema = parent::createNewsletterSubscriberSchemaTable();
        $moreFields = [
            'first_name' => [
                'type' => 'varchar',
                'length' => 255,
                'not null' => TRUE,
                'default' => '',
                'description' => 'Firstname of the person.',
            ],
            'last_name' => [
                'type' => 'varchar',
                'length' => 255,
                'not null' => TRUE,
                'default' => '',
                'description' => 'Lastname of the person.',
            ]
        ];
        $tableSchema['fields'] = array_merge($tableSchema['fields'], $moreFields);
        return $tableSchema;
    }
}