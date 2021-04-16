<?php

namespace Drupal\offres_prestataires\Config;

class Config
{
    public function getApiKey()
    {
        $config = \Drupal::config('offres_prestataires.settings');

        return $config->get('api.key');
    }
}