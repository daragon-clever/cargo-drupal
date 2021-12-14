<?php

namespace Drupal\newsletter\Event;

use Symfony\Component\EventDispatcher\Event;

class NewsletterSaveEvent extends Event
{
    const EVENT_NAME = 'newsletter_save';

    /**
     * @var array|null
     */
    protected $newsletterContact;

    public function __construct($newsletterContact)
    {
        $this->newsletterContact = $newsletterContact;
    }

    public function getNewsletterContact()
    {
        return $this->newsletterContact;
    }
}