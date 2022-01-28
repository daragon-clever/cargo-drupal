<?php

namespace Drupal\newsletter;

use Drupal\Core\Database\Connection;
use Drupal\Core\Database\Query\SelectInterface;
use Drupal\Core\Database\Query\Update;
use Drupal\Core\Datetime\DrupalDateTime;
use Drupal\newsletter\Event\NewsletterSaveEvent;

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

        return !empty($subscriber) ? (array)$subscriber : null;
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
                ->fetchAssoc();
        } catch(\Exception $e) {
            \Drupal::logger('newsletter')->error('Get failed. Message => ' . $e->getMessage());
        }

        return !empty($subscriber) ? (array)$subscriber : null;
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
        $entry['created_at'] = $this->createCurrentDatetime();
        $entry['updated_at'] = $this->createCurrentDatetime();

        $returnValue = null;
        try {
            $returnValue = $this->connection->insert(self::TABLE_NAME)
                ->fields($entry)
                ->execute();
        } catch(\Exception $e) {
            \Drupal::logger('newsletter')->error('Insert failed. Message => ' . $e->getMessage());
        }

        if (intval($returnValue)) {
            $subscriber = $this->getSubscriber($returnValue);
            $this->dispatchNewsletterSaveEvent($subscriber);

            return (int)$returnValue;
        }
    }

    /**
     * @param array $entry
     * @param int $id
     * @return array|null
     */
    public function update(array $entry, int $id): ?array
    {
        $entry['updated_at'] = $this->createCurrentDatetime();

        $count = null;
        try {
            $count = $this->queryUpdate()
                ->fields($entry)
                ->condition('id', $id)
                ->execute();
        } catch(\Exception $e) {
            \Drupal::logger('newsletter')->error('Update failed. Message => ' . $e->getMessage());
        }

        \Drupal::logger('newsletter')->notice($count);
        if (intval($count) && $count >= 1) {
            $subscriber = $this->getSubscriber($id);
            $this->dispatchNewsletterSaveEvent($subscriber);

            return $subscriber;
        }
    }

    /**
     * @param array $entry
     * @return array|null
     */
    public function updateByEmail(array $entry): ?array
    {
        $entry['updated_at'] = $this->createCurrentDatetime();

        $count = null;
        try {
            $count = $this->queryUpdate()
                ->fields($entry)
                ->condition('email', $entry['email'])
                ->execute();
        } catch(\Exception $e) {
            \Drupal::logger('newsletter')->error('Update failed. Message => ' . $e->getMessage());
        }

        \Drupal::logger('newsletter')->notice($count);
        if (intval($count) && $count >= 1) {
            $subscriber = $this->getSubscriberByEmail($entry['email']);
            $this->dispatchNewsletterSaveEvent($subscriber);

            return $subscriber;
        }
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

    private function createCurrentDatetime()
    {
        $date = new DrupalDateTime();
        return $date->format("Y-m-d H:i:s");
    }

    private function dispatchNewsletterSaveEvent($subscriber)
    {
        $event = new NewsletterSaveEvent($subscriber); //create and dispatch event for other module
        \Drupal::service('event_dispatcher')->dispatch($event::EVENT_NAME, $event);
    }
}