<?php

namespace Drupal\recherche_pdf\Config;
class ConfigFile
{
//    CONST API_URL = 'http://admin.url-qrcode.com/api/'; /* L'url curl api */
    CONST API_URL = 'http://admin.url-qrcode.com/api/index-audrey-test-2.php'; /* L'url curl api test audrey */
    CONST QRCODEADM = [
      'TBC' => [
          'URL_SITE' => 'http://fiches.turbocar-entretien.com',
          'ID_SOC' => 37,
          'DEFAULT_PDF' => 'Lang',
          'DEFAULT_LG' => 'Fr',
//          'EMAIL_FIC_TO' => ['poleweb@cargo-services.fr','a.delpoux@cargo-services.fr'],
          'EMAIL_FIC_TO' => ['a.beziat@cargo-services.fr'],
          'EMAIL_FIC_FROM' => 'no-reply@turbocar-sas.com',
      ],
      'FCA' => [
          'URL_SITE' => 'http://fiches.facom-colle-adhesif.com',
          'ID_SOC' => 47,
          'DEFAULT_PDF' => 'Lang',
          'DEFAULT_LG' => 'Fr',
<<<<<<< develop:web/modules/custom/recherchePdf/src/Config/ConfigFile.php
          'DEFAULT_DIR' => 'Fds',
          'tri_soc' => 'faca',
          'EMAIL_FIC_TO' => ['poleweb@cargo-services.fr','a.delpoux@cargo-services.fr'],
=======
//          'EMAIL_FIC_TO' => ['poleweb@cargo-services.fr','a.delpoux@cargo-services.fr'],
          'EMAIL_FIC_TO' => ['a.beziat@cargo-services.fr'],
>>>>>>> Création de cogex epi + Améliorer le module de recherche pdf:web/modules/custom/recherche_pdf/src/Config/ConfigFile.php
          'EMAIL_FIC_FROM' => 'no-reply@facom-colle-adhesif.com',
      ],
      'CGXEPI' => [
          'URL_SITE' => 'http://ficheepi.cogex-outillage.com/',
          'ID_SOC' => 51,
          'DEFAULT_PDF' => 'Lang',
          'DEFAULT_LG' => 'Fr',
//          'EMAIL_FIC_TO' => ['poleweb@cargo-services.fr','a.delpoux@cargo-services.fr'],
          'EMAIL_FIC_TO' => ['a.beziat@cargo-services.fr'],
          'EMAIL_FIC_FROM' => 'no-reply@cogex-outillage.com',
      ],

    ];
}
