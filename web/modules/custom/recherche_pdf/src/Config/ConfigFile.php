<?php

namespace Drupal\recherche_pdf\Config;
class ConfigFile
{
    CONST API_URL = 'http://admin.url-qrcode.com/api/fiches.php'; /* L'url curl api */
    CONST QRCODEADM = [
        'TBC' => [
            'URL_SITE' => 'http://fiches.turbocar-entretien.com',
            'ID_SOC' => 37,
            'DEFAULT_PDF' => 'Lang',
            'DEFAULT_LG' => 'Fr',
            'EMAIL_FIC_TO' => ['poleweb@cargo-services.fr','a.delpoux@cargo-services.fr'],
            'EMAIL_FIC_FROM' => 'no-reply@turbocar-sas.com',
        ],
        'FCA' => [
            'URL_SITE' => 'http://fiches.facom-colle-adhesif.com',
            'ID_SOC' => 47,
            'DEFAULT_PDF' => 'Lang',
            'DEFAULT_LG' => 'Fr',
            'EMAIL_FIC_TO' => ['poleweb@cargo-services.fr','a.delpoux@cargo-services.fr'],
            'EMAIL_FIC_FROM' => 'no-reply@facom-colle-adhesif.com',
        ],
        'CGXEPI' => [
            'URL_SITE' => 'http://ficheepi.cogex-outillage.com/',
            'ID_SOC' => 51,
            'DEFAULT_PDF' => 'Lang',
            'DEFAULT_LG' => 'Fr',
            'EMAIL_FIC_TO' => ['poleweb@cargo-services.fr','a.delpoux@cargo-services.fr'],
            'EMAIL_FIC_FROM' => 'no-reply@cogex-outillage.com',
        ],

    ];
}
