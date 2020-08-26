<?php
namespace Drupal\newsletter\Model;


use \Drupal\Core\Database\Connection;

class Subscriber
{
    const TABLE_SUBSCRIBER = "newsletter_subscriber";
    const ALIAS_TABLE_SUBSCRIBER = "subscriber";

    /**
     * @var Connection
     */
    private $connection;

    public function __construct()
    {
        $this->connection = \Drupal::database();
    }

    public function getSubscriber(string $email): ?array
    {
        $people = $this->connection->select(self::TABLE_SUBSCRIBER,self::ALIAS_TABLE_SUBSCRIBER)
            ->fields(self::ALIAS_TABLE_SUBSCRIBER)
            ->condition(self::ALIAS_TABLE_SUBSCRIBER.'.email', $email,'=')
            ->range(0, 1)
            ->execute()
            ->fetchAssoc();

        return $people ? $people : null;
    }

    public function insertSubscriber(array $fields): void
    {
        $this->connection->insert(self::TABLE_SUBSCRIBER)
            ->fields($fields)
            ->execute();
    }

    public function updateSubscriber(string $email, array $fields): void
    {
        $this->connection->update(self::TABLE_SUBSCRIBER)
            ->fields($fields)
            ->condition('email', $email, '=')
            ->execute();
    }
}