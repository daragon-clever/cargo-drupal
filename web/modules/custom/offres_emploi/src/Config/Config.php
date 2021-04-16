<?php

namespace Drupal\offres_emploi\Config;

class Config
{
    public function getRoutingBase()
    {
        $config = \Drupal::config('offres_emploi.settings');

        return $config->get('routing.base');
    }
}