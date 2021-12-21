<?php

namespace Drupal\newsletter\Profile;

use Drupal\Core\Datetime\DrupalDateTime;
use Drupal\newsletter\NewsletterSubscriberRepository;

class BaseProfile implements ProfileInterface
{
    /**
     * @var NewsletterSubscriberRepository
     */
    protected $subscriberRepository;

    /**
     * @var DrupalDateTime
     */
    protected $date;

    /**
     * @var bool
     */
    protected $isUpdated = false;

    public function __construct()
    {
        $this->subscriberRepository = new NewsletterSubscriberRepository();
        $this->date = new DrupalDateTime();
    }

    /**
     * @param array $dataReceived
     * @return array|null
     */
    public function saveNewsletterContact(array $dataReceived)
    {
        $subscriber = $this->subscriberRepository->getSubscriberByEmail($dataReceived['email']);
        if (empty($subscriber)) {
            $subscriberForDb = $this->formatSubscriberForInsert($dataReceived);
            $this->subscriberRepository->insert($subscriberForDb);
            $subscriber = $this->subscriberRepository->getSubscriberByEmail($dataReceived['email']);
        } else {
            $this->isUpdated = true;
            $subscriberForDb = $this->formatSubscriberForUpdate($dataReceived);
            $this->subscriberRepository->updateByEmail($subscriberForDb);
            $subscriber = $this->subscriberRepository->getSubscriberByEmail($dataReceived['email']);
        }

        return $subscriber;
    }

    protected function formatSubscriberForInsert(array $dataReceived)
    {
        $subscriberForInsert = [
            "email" => $dataReceived['email'],
            "created_at" => $this->date->format("Y-m-d H:i:s"),
            "updated_at" => $this->date->format("Y-m-d H:i:s"),
            "active" => 1,
        ];
        $moreData = $this->addDataOnSubscriberBeforeInsert($dataReceived);
        return !empty($moreData) && is_array($moreData) ? array_merge($subscriberForInsert, $moreData) : $subscriberForInsert;
    }

    protected function addDataOnSubscriberBeforeInsert(array $dataReceived)
    {
        return null;
    }

    protected function formatSubscriberForUpdate(array $dataReceived)
    {
        $subscriberForUpdate = [
            'email' => $dataReceived['email'],
            "updated_at" => $this->date->format("Y-m-d H:i:s"),
            "active" => 1,
        ];
        $moreData = $this->addDataOnSubscriberBeforeUpdate($dataReceived);
        return !empty($moreData) && is_array($moreData) ? array_merge($subscriberForUpdate, $moreData) : $subscriberForUpdate;
    }

    protected function addDataOnSubscriberBeforeUpdate(array $dataReceived)
    {
        return null;
    }

    public function getTxtReturn(): string
    {
        if ($this->isUpdated) {
            $msg = t("You have just updated your newsletter preferences");
        } else {
            $msg = t("Thank you for subscribing to the newsletter");
        }
        return $msg;
    }
}