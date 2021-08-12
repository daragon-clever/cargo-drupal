<?php

namespace Drupal\recherche_pdf\Helper;

use Drupal\recherche_pdf\Config\Config;

class PdfSearch
{
    const PDF_URL_KEY = "url";
    const PDF_NAME_KEY = "name";

    /**
     * @var string
     */
    private $entityKey;

    /**
     * @var string
     */
    private $sku;

    /**
     * @var null string
     */
    private $lot;

    /**
     * @var array
     */
    private $entityConfig;

    public function __construct($entity, $sku, $lot = null)
    {
        $this->entityKey = $entity;
        $this->sku = $sku;
        $this->lot = $lot;

        $this->entityConfig = Config::getQrcodeConfig($this->entityKey);
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function execute()
    {
        if ($this->isEntityConfigured()) {
            $pdfRequest = new PdfRequest();
            $params = [
                'product_sku' => $this->sku,
                'product_lot' => $this->lot,
                'product_type' => $this->entityConfig['PRODUCT_TYPE'],
                'lang' => strtoupper(\Drupal::languageManager()->getCurrentLanguage()->getId()),
                'entity_id' => $this->entityConfig['ID_SOC'],
                'default_pdf' => $this->entityConfig['DEFAULT_PDF'],
                'default_lg' => $this->entityConfig['DEFAULT_LG'],
                'prod_mode' => Config::getProdModeConfig(),
            ];
            $pdfGet = $pdfRequest->getPdf($params);

            $returnData = $this->formatReturnData($pdfGet);
            if (empty($returnData)) {
                $txtError = t('File(s) not found').". Sku : ".$this->sku.".";
                if (!empty($this->lot)) $txtError .= " Lot : ".$this->lot.".";

                $this->sendMail($txtError);
                throw new \Exception($txtError." ".t('Try again with another reference.'));
            } else {
                return $returnData; //success
            }
        } else {
            $txtError = 'Société/entité non configuré : '.$this->entityKey;

            $this->sendMail($txtError);
            throw new \Exception(t('This search form are not configured yet. Please try again later.'));
        }
    }

    private function isEntityConfigured()
    {
        return (!is_null($this->entityConfig));
    }

    private function formatReturnData($requestReturn)
    {
        $returnData = [];
        if (!empty($requestReturn) && is_array($requestReturn)) {
            foreach ($requestReturn as $fileObj) {
                if (!is_null($fileObj)
                    && isset($fileObj[PdfRequest::PDF_DISTANT_FILENAME_KEY])
                    && !empty($fileObj[PdfRequest::PDF_DISTANT_FILENAME_KEY])
                    && isset($fileObj[PdfRequest::PDF_FILENAME_KEY])
                    && !empty($fileObj[PdfRequest::PDF_FILENAME_KEY])) {
                    $urlToDownloadFile = $this->getDistantFileUrl($fileObj[PdfRequest::PDF_DISTANT_FILENAME_KEY]);
                    if ($this->isValidUrl($urlToDownloadFile)) {
                        $returnData[] = [
                            self::PDF_URL_KEY => $urlToDownloadFile,
                            self::PDF_NAME_KEY => $fileObj[PdfRequest::PDF_FILENAME_KEY]
                        ];
                    }
                }
            }
        }
        return $returnData;
    }

    private function getDistantFileUrl($distantFile)
    {
        return $this->entityConfig['URL_SITE']."/".$distantFile;
    }

    private function isValidUrl($url)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        $status = ($code == 200) ? TRUE : FALSE;

        curl_close($ch);

        return $status;
    }

    private function sendMail($body)
    {
        $mailManager = \Drupal::service('plugin.manager.mail');

        $module = 'recherche_pdf';
        $key = 'product_not_found';
        $langcode = \Drupal::currentUser()->getPreferredLangcode();
        $reply = false;
        $send = true;

        $paramMail['cc'] = Config::EMAIL_TEAM;
        $paramMail['from'] = Config::EMAIL_TEAM;
        $paramMail['subject'] = "[recherche_pdf] Erreur lors d'une recherche PDF";
        $paramMail['message'] = $body;

        $mailManager->mail($module, $key, Config::API_URL, $langcode, $paramMail, $reply, $send);
    }
}