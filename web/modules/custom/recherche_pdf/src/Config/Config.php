<?php

namespace Drupal\recherche_pdf\Config;

class Config
{
    const DEFAULT_PDF = "Lang";
    const DEFAULT_LG = "Fr";

    CONST API_URL = 'http://admin.url-qrcode.com/api/fiches.php';
    const EMAIL_TEAM = 'poleweb@cargo-services.fr';

    public static function getProdModeConfig()
    {
        $config = \Drupal::config('recherche_pdf.settings');
        return (bool)$config->get('api.prod_mode');
    }

    public static function getQrcodeConfig(string $entity)
    {
        $config = self::qrcodeConfig();
        if (isset($config[$entity]) && !empty($config[$entity])) return $config[$entity];
    }

    public static function qrcodeConfig()
    {
        $return['TBCNOT'] = self::formatCompanyConfigArray(37, 'http://fiches.turbocar-entretien.com', 'Not');
        $return['TBCDET'] = self::formatCompanyConfigArray(37, 'http://fiches.turbocar-entretien.com', 'Det');
        $return['FCA'] = self::formatCompanyConfigArray(47, 'http://fiches.facom-colle-adhesif.com');
        $return['CGXEPI'] = self::formatCompanyConfigArray(51, 'http://ficheepi.cogex-outillage.com');
        $return['GE'] = self::formatCompanyConfigArray(1, 'http://fiche.gers-equipement.fr');
        $return['CGXMC'] = self::formatCompanyConfigArray(48, 'http://www.cogex-mastic-colle.com');
        $return['CGXECL'] = self::formatCompanyConfigArray(36, 'http://www.cogex-eclairage.com');
        return $return;
    }

    private static function formatCompanyConfigArray(
        int $entityId,
        string $filesUrl,
        string $specialProductType = null,
        string $defaultLg = null,
        string $defaultPdf = null
    )
    {
        return [
            'ID_SOC' => $entityId,
            'URL_SITE' => $filesUrl,
            'PRODUCT_TYPE' => $specialProductType,
            'DEFAULT_LG' => !empty($defaultLg) ? $defaultLg : self::DEFAULT_LG,
            'DEFAULT_PDF' => !empty($defaultPdf) ? $defaultPdf : self::DEFAULT_PDF,
        ];
    }
}
