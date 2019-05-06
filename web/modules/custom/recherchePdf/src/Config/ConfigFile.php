<?php
/**
 * Created by PhpStorm.
 * User: abh
 * Date: 02/05/2018
 * Time: 11:41
 */

namespace Drupal\recherchePdf\Config;
class ConfigFile
{
    CONST API_URL = 'http://admin.url-qrcode.com/api/'; /* L'url curl api */
    CONST QRCODEADM = [
      'TBC' => [
          'URL_SITE' => 'http://fiches.turbocar-entretien.com',
          'ID_SOC' => 37,
          'CODE_SOC' => 'TBC',
          'DEFAULT_PDF' => 'Lang',
          'DEFAULT_LG' => 'Fr',
          'DEFAULT_DIR' => 'Det',
          'tri_soc' => 'turb',
          'EMAIL_FIC_TO' => ['poleweb@cargo-services.fr','a.delpoux@cargo-services.fr'],
          'EMAIL_FIC_FROM' => 'no-reply@turbocar-sas.com',
      ],
      'FCA' => [
          'URL_SITE' => 'http://fiches.facom-colle-adhesif.com',
          'ID_SOC' => 47,
          'CODE_SOC' => 'FCA',
          'DEFAULT_PDF' => 'Lang',
          'DEFAULT_LG' => 'Fr',
          'DEFAULT_DIR' => 'Fds',
          'tri_soc' => 'faca',
          'EMAIL_FIC_TO' => ['poleweb@cargo-services.fr','a.delpoux@cargo-services.fr'],
          'EMAIL_FIC_FROM' => 'no-reply@facom-colle-adhesif.com',
      ],

    ];
}
