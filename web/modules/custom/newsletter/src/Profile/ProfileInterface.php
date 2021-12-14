<?php

namespace Drupal\newsletter\Profile;

interface ProfileInterface
{
    public function saveNewsletterContact(array $dataReceived);

    public function getTxtReturn(): string;
}