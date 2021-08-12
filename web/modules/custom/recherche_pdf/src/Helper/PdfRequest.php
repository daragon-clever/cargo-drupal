<?php

namespace Drupal\recherche_pdf\Helper;

use Drupal\recherche_pdf\Config\Config;

class PdfRequest
{
    const PDF_FILENAME_KEY = "filename";
    const PDF_DISTANT_FILENAME_KEY = "distant_filename";

    public function getPdf($config)
    {
        $args = $this->formatArgsForCurlRequest($config);
        $apiReturn = $this->getPdfCurlRequest($args);
        $result = $this->formatReturnData($apiReturn);
        return $result;
    }

    private function formatArgsForCurlRequest($config)
    {
        return [
            'RefProd' => $config['product_sku'],
            'LotProd' => $config['product_lot'],
            'TypeProd' => $config['product_type'],
            'LANG' => $config['lang'],
            'ID_SOC' => $config['entity_id'],
            'DEFAULT_PDF' => $config['default_pdf'],
            'DEFAULT_LG' => $config['default_lg'],
            'PROD' => $config['prod_mode'],
        ];
    }

    private function getPdfCurlRequest($args = [])
    {
        $result = null;

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, Config::API_URL);
        curl_setopt($curl, CURLOPT_COOKIESESSION, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $args);
        $return = curl_exec($curl);
        curl_close($curl);
        $return = \GuzzleHttp\json_decode($return);

        return $return;
    }

    private function formatReturnData($apiReturnFiles)
    {
        $return = [];

        if (!is_array($apiReturnFiles)) {
            $rslt[] = $apiReturnFiles;
        } else {
            $rslt = $apiReturnFiles;
        }

        foreach ($rslt as $file) {
            if (!is_null($file) && !empty($file->fileDistant) && !empty($file->fileName)) {
                $return[] = [
                    self::PDF_FILENAME_KEY => $file->fileName,
                    self::PDF_DISTANT_FILENAME_KEY => $file->fileDistant,
                ];
            }
        }
        return $return;
    }
}