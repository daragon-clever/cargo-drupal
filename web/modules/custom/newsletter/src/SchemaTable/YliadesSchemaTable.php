<?php

namespace Drupal\newsletter\SchemaTable;

class YliadesSchemaTable extends BaseSchemaTable
{
    public function createNewsletterSubscriberSchemaTable(): array
    {
        $tableSchema = parent::createNewsletterSubscriberSchemaTable();
        $moreFields = [
            'subscriptions' => [
                'type' => 'text',
                'size' => 'big',
                'description' => 'Subscriptions list of subscriber',
            ]
        ];
        $tableSchema['fields'] = array_merge($tableSchema['fields'], $moreFields);
        return $tableSchema;
    }
}