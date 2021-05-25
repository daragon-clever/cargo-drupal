<?php

namespace Drupal\recherche_pdf\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Drupal\Core\Url;
use \Drupal\recherche_pdf\Config\ConfigFile;


class RechercheController extends ControllerBase
{
    private const KEY_ALERT_SHORT_MSG = "shortMsg";
    private const KEY_ALERT_MSG = "msg";
    private const KEY_ALERT_ERROR_FOR_USER = "errorForUser";

    protected $config;
    protected $qrcodeadmProd;
    protected $dataSoc;

    public function __construct()
    {
        $this->config = new ConfigFile();

        $qrcodeadm =  \Drupal::config('system.qrcodeadm')->get('soc', FALSE);
        $this->qrcodeadmProd =  \Drupal::config('system.qrcodeadm')->get('prod', FALSE);

        if ($qrcodeadm != null) {
            $this->dataSoc = $this->config::QRCODEADM[$qrcodeadm];
        }
    }

    /**
     * Page with search form - load template
     *
     * @return array
     */
    public function displayForm($type = null)
    {
        return [
            '#theme' => 'recherche_pdf--recherche',
            '#type' => $type
        ];
    }

    /**
     * Exec after click on "download" of "display" form button
     *
     * @param Request $request
     * @param $action
     * @return array|RedirectResponse|Response
     */
    public function getPdf(Request $request, $action)
    {
        if($this->dataSoc != null) {
            $pdfArr = $this->getPdfInfos($request);
            $alert = $this->alertPdfArray($pdfArr);

            if (is_null($alert)) {
                if ($action == "download") {
                    return $this->dowloadPdf($pdfArr);
                } else if ($action == "display") {
                    return $this->displayListOfPdf($pdfArr);
                }
            } else {
                $this->sendMail($alert);
            }
        } else {
            $obj = "Pas de société configurée";
            $msg = "Pas de société configurée dans le module recherche_pdf sur Drupal";
            $errorForUser = "Pas de fiches pour cette société";
            $alert = $this->setAlertArray($obj, $msg, $errorForUser);
            $this->sendMail($alert);
        }

        $urlRedirect = $request->get('urlRedirect');
        return $this->myRedirection($urlRedirect, $alert[self::KEY_ALERT_ERROR_FOR_USER]);
    }

    /**
     * Download only one file after list display
     *
     * @param Request $request
     * @return Response
     */
    public function downloadFileOnly(Request $request)
    {
        return $this->headersResponse($request->get('urlDl'), $request->get('name'));
    }

    /**
     * Get Pdf infos (and format) after call api
     *
     * @param Request $request
     * @return mixed
     */
    private function getPdfInfos(Request $request)
    {
        //get value of form request
        $refProduit = $request->get('refProduit');
        $lotProduit = $request->get('lotProduit');
        $lang = strtoupper(\Drupal::languageManager()->getCurrentLanguage()->getId());

        $postData = [
            'RefProd' => $refProduit,
            'LotProd' => $lotProduit,
            'LANG' => $lang,
            'ID_SOC' => $this->dataSoc['ID_SOC'],
            'DEFAULT_PDF' => $this->dataSoc['DEFAULT_PDF'],
            'DEFAULT_LG' => $this->dataSoc['DEFAULT_LG'],
            'PROD' => $this->qrcodeadmProd,
        ];
        $rslt = $this->getPdfByRefOrLotCurl($postData); //call api and get response

        if (!is_array($rslt)) {
            $resultat[] = $rslt;
        } else {
            $resultat = $rslt;
        }

        $arrFiles["ref"] = $refProduit;
        $arrFiles["lot"] = $lotProduit;
        $arrFiles["rsltApi"] = [];
        foreach ($resultat as $file) {
            if (!is_null($file) && !empty($file->fileDistant) && !empty($file->fileName)) {
                $urlToDownloadFile = $this->dataSoc['URL_SITE'] . "/" . $file->fileDistant;
                $arrFiles['rsltApi'][] = [
                    'urlDl' =>$urlToDownloadFile,
                    'name' => $file->fileName
                ];
            }
        }

        return $arrFiles;
    }

    /**
     * Set alert if file or product not found/exist
     *
     * @param $arrPdf
     * @return array|null
     */
    private function alertPdfArray($arrPdf)
    {
        if (!empty($arrPdf['rsltApi'])) {
            $success = false;
            foreach ($arrPdf['rsltApi'] as $file) {
                if ($this->isUrlExist($file['urlDl'])) {
                    $success = true;
                }
            }
            if (!$success) {
                $shortMsgRedirect = "Fichier pdf introuvable";
                $msgRedirect = "La fiche pour le produit reference ".$arrPdf['ref']
                    ." lot ".$arrPdf['lot']." est introuvable";
            }
        } else {
            $shortMsgRedirect = "Produit introuvable";
            $msgRedirect = "Le produit pour la reference ".$arrPdf['ref']." lot ".$arrPdf['lot']." est introuvable";
        }

        $return = NULL;
        if (isset($shortMsgRedirect) && isset($msgRedirect)) {
            $return = $this->setAlertArray($shortMsgRedirect,$msgRedirect);
        }

        return $return;
    }

    /**
     * Set correct (header - zip or only one file) for download
     *
     * @param $arrPdf
     * @return Response
     */
    private function dowloadPdf($arrPdf)
    {
        if (count($arrPdf['rsltApi']) > 1) {
            return $this->headersResponseZip($arrPdf['rsltApi']);
        } else {
            return $this->headersResponse($arrPdf['rsltApi'][0]['urlDl'], $arrPdf['rsltApi'][0]['name']);
        }
    }

    /**
     * Load template listing files
     *
     * @param $arrPdf
     * @return array
     */
    private function displayListOfPdf($arrPdf)
    {
        return [
            '#theme' => 'recherche_pdf--liste',
            '#rslt' => $arrPdf['rsltApi']
        ];
    }

    /**
     * Call API admin.url-qcodes and return files array
     *
     * @param array $postfields
     * @return mixed
     */
    private function getPdfByRefOrLotCurl($postfields = [])
    {
        $result = null;
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $this->config::API_URL);
        curl_setopt($curl, CURLOPT_COOKIESESSION, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $postfields);
        $return = curl_exec($curl);
        curl_close($curl);
        $return = \GuzzleHttp\json_decode($return);
        return $return;
    }

    /**
     * Check download file url
     *
     * @param $url
     * @return bool
     */
    private function isUrlExist($url)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($code == 200) {
            $status = true;
        } else {
            $status = false;
        }
        curl_close($ch);
        return $status;
    }

    /**
     * Format alert
     *
     * @param $obj
     * @param $msg
     * @param string $errorForUser
     * @return array
     */
    private function setAlertArray($obj, $msg, $errorForUser = "")
    {
        return [
            self::KEY_ALERT_SHORT_MSG => $obj,
            self::KEY_ALERT_MSG => $msg,
            self::KEY_ALERT_ERROR_FOR_USER => !empty($errorForUser) ? $errorForUser : $msg
        ];
    }

    /**
     * Alert when sku not found in admin url qrcode
     *
     * @param $from
     * @param $obj
     * @param $txt
     */
    private function sendMail($alertArr): void
    {
        if (!empty($obj) && !empty($txt)) {
            $mailManager = \Drupal::service('plugin.manager.mail');

            $module = 'recherche_pdf';
            $key = 'product_not_found';
            $langcode = \Drupal::currentUser()->getPreferredLangcode();

            $paramMail['cc'] = $this->config::EMAIL_TEAM;
            $paramMail['from'] = $this->dataSoc['EMAIL_FIC_FROM'];
            $paramMail['subject'] = $alertArr[self::KEY_ALERT_SHORT_MSG];
            $paramMail['message'] = $alertArr[self::KEY_ALERT_MSG];

            $reply = false;
            $send = true;

            $mailManager->mail($module, $key, $this->config::API_URL, $langcode, $paramMail, $reply, $send);
        }
    }

    /**
     * Redirect to form page with 1 pdf on header to download in client's computer
     *
     * @param $url
     * @param $fileName
     * @return Response
     */
    private function headersResponse($url,$fileName)
    {
        $response = new Response();
        $response->headers->set('Content-type', 'application/octet-stream');
        $response->headers->set('Content-Disposition', sprintf('attachment; filename="%s"', $fileName));
        $response->setContent(file_get_contents($url));

        return $response;
    }

    /**
     * Redirect to form page with many pdf on header to download in client's computer
     *
     * @param $arrFiles
     * @return Response
     */
    private function headersResponseZip($ref,$arrFiles)
    {
        $zip = new \ZipArchive();
        $zipName = 'Documents_'.$ref.'_'.date("Ymd-his").'.zip';

        $zip->open($zipName,  \ZipArchive::CREATE);
        foreach ($arrFiles as $file) {
            $zip->addFromString(basename($file['name']),  file_get_contents($file['url']));
        }
        $zip->close();

        $response = new Response(file_get_contents($zipName));
        $response->headers->set('Content-Type', 'application/zip');
        $response->headers->set('Content-Disposition', 'attachment;filename="' . $zipName . '"');
        $response->headers->set('Content-length', filesize($zipName));
        @unlink($zipName);

        return $response;
    }

    /**
     * Redirect user with error message - redirect on current page or home page
     *
     * @param $urlRedirect
     * @param $message
     * @return RedirectResponse
     */
    private function myRedirection($urlRedirect, $message)
    {
        $messenger = \Drupal::messenger();
        $messenger->addMessage(
            $this->t($message),
            'error',
            true
        );
        if(!empty($urlRedirect)) {
            return $response = new RedirectResponse($urlRedirect);
        } else {
            return $this->redirect('<front>');
        }
    }
}
