<?php

namespace Drupal\newsletter;

use Drupal\Core\Database\Connection;
use Drupal\Core\Database\Query\SelectInterface;
use Drupal\Core\Database\Query\Update;

class NewsletterSubscriberRepository
{
    public const TABLE_NAME = 'newsletter_subscriber';

    /**
     * @var Connection
     */
    private $connection;

    public function __construct()
    {
        $this->connection = \Drupal::database();
    }

    /**
     * @return array|null
     */
    public function getAll()
    {
        try {
            $subscriberList = $this->querySelect()
                ->execute()
                ->fetchAssoc()
            ;
        } catch(\Exception $e) {
            \Drupal::logger('marketing_automation_core')->error('Get all failed. Message => ' . $e->getMessage());
        }

        return !empty($subscriberList) ? $subscriberList : null;
    }

    /**
     * @param string $id
     * @return array|null
     */
    public function getSubscriber($id): ?array
    {
        try {
            $subscriber = $this->querySelect()
                ->condition('id', $id)
                ->range(0, 1)
                ->execute()
                ->fetchAssoc();
        } catch(\Exception $e) {
            \Drupal::logger('newsletter')->error('Get failed. Message => ' . $e->getMessage());
        }

        return !empty($subscriber) ? $subscriber : null;
    }

    /**
     * @param string $email
     * @return array|null
     */
    public function getSubscriberByEmail(string $email): ?array
    {
        try {
            $subscriber = $this->querySelect()
                ->condition('email', $email)
                ->range(0, 1)
                ->execute()
                ->fetchAssoc()
            ;
        } catch(\Exception $e) {
            \Drupal::logger('newsletter')->error('Get failed. Message => ' . $e->getMessage());
        }

        return !empty($subscriber) ? $subscriber : null;
    }

    public function getSubscribersByCondition(string $conditionName, $conditionValue, string $operator = null)
    {
        try {
            $subscriber = $this->querySelect();
            if ($operator) $subscriber = $subscriber->condition($conditionName, $conditionValue, $operator);
            else $subscriber->condition($conditionName, $conditionValue);

            $subscriber = $subscriber->execute();
        } catch(\Exception $e) {
        \Drupal::logger('newsletter')->error('Get failed. Message => ' . $e->getMessage());
    }

        return !empty($subscriber) ? $subscriber : null;
    }

    /**
     * @param array $entry
     * @return int|null
     */
    public function insert(array $entry): ?int
    {
        try {
            $return_value = $this->connection->insert(self::TABLE_NAME)
                ->fields($entry)
                ->execute();
        } catch(\Exception $e) {
            \Drupal::logger('newsletter')->error('Insert failed. Message => ' . $e->getMessage());
        }

        return intval($return_value) ?? null;
    }

    /**
     * @param array $entry
     * @param int $id
     * @return int
     */
    public function update(array $entry, int $id): int
    {
        try {
            $count = $this->queryUpdate()
                ->fields($entry)
                ->condition('id', $id)
                ->execute()
            ;
        } catch(\Exception $e) {
            \Drupal::logger('newsletter')->error('Update failed. Message => ' . $e->getMessage());
        }

        return intval($count) ?? 0;
    }

    /**
     * @param array $entry
     * @return int
     */
    public function updateByEmail(array $entry): int
    {
        try {
            $count = $this->queryUpdate()
                ->fields($entry)
                ->condition('email', $entry['email'])
                ->execute()
            ;
        } catch(\Exception $e) {
            \Drupal::logger('newsletter')->error('Update failed. Message => ' . $e->getMessage());
        }


        return intval($count) ?? 0;
    }

    /**
     * @return Update
     */
    private function queryUpdate(): Update
    {
        return $this->connection->update(self::TABLE_NAME);
    }

    /**
     * @return SelectInterface
     */
    private function querySelect(): SelectInterface
    {
        return $this->connection->select(self::TABLE_NAME)
            ->fields(self::TABLE_NAME);
    }
}