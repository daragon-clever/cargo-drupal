<?php
declare(strict_types=1);

namespace Drupal\offres_emploi\Helper;

trait OffreEmploiHelperTrait
{
    /**
     * List of all sites that use Drupal
     * @var array
     */
    public static $nameCompany = [
        'ostaria' => 'C2S',
        'centrakor' => ['CENTRAKOR', 'CENTRAKOR STORES'],
        'comptoirdefamille' => 'Comptoir de Famille',
        'technosource-industrie' => 'TECHNO SOURCE INDUSTRIES',
        'cestdeuxeuros' => 'CEDIF',
        'yliades' => 'YLIADES',
        'roldan' => 'ROLDAN',
        'merchcie' => 'MERCH ET CIE',
        'groupecargo' => 'CARGO',
        'cogex' => 'COGEX',
        'ruecab' => 'RUECAB',
        'gersequipement' => 'GERS-EQUIPEMENT',
        'turbocar' => 'TURBOCAR',
    ];

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