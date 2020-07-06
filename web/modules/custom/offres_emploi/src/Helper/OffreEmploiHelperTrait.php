<?php
declare(strict_types=1);

namespace Drupal\offres_emploi\Helper;

trait OffreEmploiHelperTrait
{
    /**
     * Get the Site Name
     * @return string
     */
    private function getSiteName() : string
    {
        $sitePath = \Drupal::service('site.path');
        $sitePath = explode('/', $sitePath);

        return $sitePath[1];
    }

}