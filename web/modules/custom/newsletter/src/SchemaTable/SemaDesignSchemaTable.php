<?php

namespace Drupal\newsletter\SchemaTable;

class SemaDesignSchemaTable extends BaseSchemaTable
{
    public function createNewsletterSubscriberSchemaTable(): array
    {
        $tableSchema = parent::createNewsletterSubscriberSchemaTable();
        $moreFields = [
            'is_pro' => [
                'type' => 'int',
                'length' => 11,
                'not null' => TRUE,
                'default' => '0',
                'description' => 'Is a pro person',
            ],
        ];
        $tableSchema['fields'] = array_merge($tableSchema['fields'], $moreFields);
        return $tableSchema;
    }
}