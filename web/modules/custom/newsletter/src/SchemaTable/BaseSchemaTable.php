<?php

namespace Drupal\newsletter\SchemaTable;

class BaseSchemaTable
{
    public function createNewsletterSubscriberSchemaTable(): array
    {
        return [
            'description' => 'Stores email for newsletter.',
            'fields' => [
                'id' => [
                    'type' => 'serial',
                    'not null' => TRUE,
                    'description' => 'Primary Key: Unique email ID.',
                ],
                'created_at' => [
                    'type' => 'varchar',
                    'length' => 100,
                    'mysql_type' => 'datetime',
                    'not null' => TRUE,
                ],
                'updated_at' => [
                    'type' => 'varchar',
                    'length' => 100,
                    'mysql_type' => 'datetime',
                    'not null' => TRUE,
                ],
                'active' => [
                    'type' => 'int',
                    'length' => 11,
                    'not null' => TRUE,
                    'default' => '0',
                    'description' => 'Active subscription of the person.',
                ],
                'email' => [
                    'type' => 'varchar',
                    'length' => 255,
                    'not null' => TRUE,
                    'default' => '',
                    'description' => 'Email of the person.',
                ],
            ],
            'primary key' => ['id'],
            'indexes' => [
                'email' => ['email'],
            ],
        ];
    }
}