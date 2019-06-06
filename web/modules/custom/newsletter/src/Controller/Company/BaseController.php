<?php

namespace Drupal\newsletter\Controller\Company;


use Drupal\newsletter\Controller\NewsletterController;

class BaseController extends NewsletterController
{
    public function setSchemaTableSubscriber(): array
    {
        $array = array(
            'description' => 'Stores email for newsletter.',
            'fields' => array(
                'id' => array(
                    'type' => 'serial',
                    'not null' => TRUE,
                    'description' => 'Primary Key: Unique email ID.',
                ),
                'created_at' => array(
                    'type' => 'varchar',
                    'length' => 100,
                    'mysql_type' => 'datetime',
                    'not null' => FALSE,
                ),
                'updated_at' => array(
                    'type' => 'varchar',
                    'length' => 100,
                    'mysql_type' => 'datetime',
                    'not null' => FALSE,
                ),
                'email' => array(
                    'type' => 'varchar',
                    'length' => 255,
                    'not null' => TRUE,
                    'default' => '',
                    'description' => 'Email of the person.',
                ),
                'civ' => array(
                    'type' => 'varchar',
                    'length' => 10,
                    'not null' => FALSE,
                ),
                'first_name' => array(
                    'type' => 'varchar',
                    'length' => 100,
                    'description' => 'First name of the person.',
                ),
                'last_name' => array(
                    'type' => 'varchar',
                    'length' => 100,
                    'description' => 'Last name of the person.',
                ),
                'tel_number' => array(
                    'type' => 'varchar',
                    'length' => 50,
                ),
                'fax_number' => array(
                    'type' => 'varchar',
                    'length' => 50,
                ),
                'mobile_phone' => array(
                    'type' => 'varchar',
                    'length' => 50,
                ),
                'address1' => array(
                    'type' => 'varchar',
                    'length' => 255,
                    'description' => 'Address 1 of the person.',
                ),
                'address2' => array(
                    'type' => 'varchar',
                    'length' => 255,
                    'description' => 'Address 2 of the person.',
                ),
                'cp' => array(
                    'type' => 'varchar',
                    'length' => 255,
                    'description' => 'Postal Code 2 of the person.',
                ),
                'city' => array(
                    'type' => 'varchar',
                    'length' => 255,
                    'description' => 'City 2 of the person.',
                ),
                'country' => array(
                    'type' => 'varchar',
                    'length' => 255,
                    'description' => 'Country 2 of the person.',
                ),
                'company' => array(
                    'type' => 'varchar',
                    'length' => 255,
                ),
                'siret' => array(
                    'type' => 'varchar',
                    'length' => 255,
                ),
                'from_site' => array(
                    'type' => 'varchar',
                    'length' => 255,
                    'not null' => TRUE,
                    'default' => '',
                    'description' => 'Site on which the user has registered.',
                ),
                'exported' => array(
                    'type' => 'int',
                    'size' => 'tiny',
                    'not null' => TRUE,
                    'default' => '0',
                    'description' => '',
                ),
            ),
            'primary key' => array('id'),
            'indexes' => array(
                'email' => array('email'),
                'exported' => array('exported'),
            ),
        );

        return $array;
    }

    public function setSchemaTableSubscription(): array
    {
        $array = array(
            'description' => 'Stores subscription for newsletter subscriber.',
            'fields' => array(
                'id' => array(
                    'type' => 'serial',
                    'not null' => TRUE,
                    'description' => 'Primary Key: Unique email ID.',
                ),
                'id_subscriber' => array(
                    'type' => 'int',
                    'length' => 11,
                    'not null' => TRUE,
                    'description' => 'Subscriber ID.',
                ),
                'subscriptions' => array(
                    'type' => 'varchar',
                    'length' => 255,
                    'not null' => TRUE,
                    'default' => '',
                    'description' => 'Subscriptions of the person.',
                ),
                'active' => array(
                    'type' => 'int',
                    'length' => 11,
                    'not null' => TRUE,
                    'default' => '0',
                    'description' => 'Active subscription of the person.',
                )
            ),
            'primary key' => array('id')
        );

        return $array;
    }
}