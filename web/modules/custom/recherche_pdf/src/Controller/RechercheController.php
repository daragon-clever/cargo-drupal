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


class RechercheController extends ControllerBase
{
    protected $config;
    protected $qrcodeadmProd;
    protected $qrcodeadmMail;
    protected $dataSoc;

    public function __construct()
    {
        $this->config = new \Drupal\recherche_pdf\Config\ConfigFile();

        $qrcodeadm =  \Drupal::config('system.qrcodeadm')->get('soc', FALSE);
        $this->qrcodeadmProd =  \Drupal::config('system.qrcodeadm')->get('prod', FALSE);
        $this->qrcodeadmMail =  \Drupal::config('system.qrcodeadm')->get('mailTesterreur', FALSE);

        if ($qrcodeadm != null) {
            $this->dataSoc = $this->config::QRCODEADM[$qrcodeadm];
        }
    }

    public function displayForm()
    {
        return array(
            '#theme' => 'recherche_pdf--recherche'
        );
    }

    public function getPdf(Request $request)
    {
        //get value of form request
        $refProduit = $request->get('refProduit');
        $lotProduit = $request->get('lotProduit');
        $lang = strtoupper(\Drupal::languageManager()->getCurrentLanguage()->getId());
        $urlRedirect = $request->get('urlRedirect');

        //param mail config
        $paramMail['from'] = $this->dataSoc['EMAIL_FIC_FROM'];
        $paramMail['to'] = $this->qrcodeadmMail != null ? $this->qrcodeadmMail : implode(', ' , $this->dataSoc['EMAIL_FIC_TO']);
        $paramMail['fiches'] = $refProduit." ".$lotProduit;

        $redirectMessage = "";

        if($this->dataSoc != null) {
            //array data for application
            $postData = [
                'RefProd' => $refProduit,
                'LotProd' => $lotProduit,
                'LANG' => $lang,
                'ID_SOC' => $this->dataSoc['ID_SOC'],
                'DEFAULT_PDF' => $this->dataSoc['DEFAULT_PDF'],
                'DEFAULT_LG' => $this->dataSoc['DEFAULT_LG'],
                'PROD' => $this->qrcodeadmProd,
            ];
            //call api and get response
            $rslt = $this->getPdfByRefOrLotCurl($postData);

            if (is_array($rslt)) {
                $success = false;
                $arrFiles = array();
                foreach ($rslt as $file) {
                    if (!is_null($file) && !empty($file->fileDistant) && !empty($file->fileName)) {
                        $urlToDownloadFile = $this->dataSoc['URL_SITE'] . "/" . $file->fileDistant;
                        if ($this->is_url_exist($urlToDownloadFile)) {
                            $success = true;
                            $arrFiles[] = array(
                                'url' =>$urlToDownloadFile,
                                'name' => $file->fileName
                            );
                        }
                    }
                }
                if ($success === false) {
                    $redirectMessage = "Fichier pdf introuvable";
                    $paramMail['subject'] = "Fichier pdf introuvable";
                    $paramMail['body'] = "Le Fichier pour Le produit reference ".$refProduit." lot ".$lotProduit." est introuvable";
                    $this->sendMailNoFile($paramMail);
                } elseif (count($arrFiles) > 1) {
                    return $this->headersResponseZip($arrFiles);
                } else {
                    return $this->headersResponse($urlToDownloadFile, $arrFiles[0]['name']);
                }
            } elseif (!is_null($rslt) && !empty($rslt->fileDistant) && !empty($rslt->fileName)) {
                $urlToDownloadFile = $this->dataSoc['URL_SITE'] . "/" . $rslt->fileDistant;//url to get pdf file
                if ($this->is_url_exist($urlToDownloadFile)) {
                    return $this->headersResponse($urlToDownloadFile, $rslt->fileName);
                } else {
                    $redirectMessage = "Fichier pdf introuvable - ".$paramMail['fiches'];
                    $paramMail['subject'] = "Fichier pdf introuvable - ".$paramMail['fiches'];
                    $paramMail['body'] = "Le Fichier ".$rslt->fileName." pour Le produit reference ".$postData['RefProd']." lot ".$postData['LotProd']." est introuvable";
                    $this->sendMailNoFile($paramMail);
                }
            } else {
                $redirectMessage = "Produit ".$paramMail['fiches']." introuvable";
                $paramMail['subject'] = "Produit introuvable - ".$paramMail['fiches'];
                $paramMail['body'] = "Le produit reference ".$postData['RefProd']." lot ".$postData['LotProd']." est introuvable dans la base de données.";
                $this->sendMailNoFile($paramMail);
            }
        } else {
            $redirectMessage = "Aucune fiche de disponible";
        }
        return $this->myRedirection($urlRedirect, $redirectMessage);
    }

    public function getPdfByRefOrLotCurl($postfields = [])
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

    protected function is_url_exist($url)
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

    protected function headersResponse($url,$fileName)
    {
        $response = new Response();
        $response->headers->set('Content-type', 'application/octet-stream');
        $response->headers->set('Content-Disposition', sprintf('attachment; filename="%s"', $fileName));
        $response->setContent(file_get_contents($url));
        $response->setStatusCode(200);
        $response->headers->set('Content-Transfer-Encoding', 'binary');
        $response->headers->set('Pragma', 'no-cache');
        $response->headers->set('Expires', '0');
        return $response;
    }

    protected function headersResponseZip($arrFiles)
    {
        $zip = new \ZipArchive();
        $zipName = 'Documents_'.date("Ymd-his").'.zip';

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

    protected  function sendMailNoFile($params)
    {
        $mailManager = \Drupal::service('plugin.manager.mail');
        $module = 'recherche_pdf';
        $key = 'fiche_Pdf';
        $to = $params['to'];
        $langcode = \Drupal::currentUser()->getPreferredLangcode();

        $reply = false;
        $send = true;
        $result = $mailManager->mail($module, $key, $to, $langcode, $params, $reply, $send);
    }

    protected function myRedirection($urlRedirect, $message)
    {
        //redirect because no config in Config File
        $messenger = \Drupal::messenger();
        $messenger->addMessage(
            $this->t($message),
            'error',
            true
        );
        if(!empty($urlRedirect)) {
            $response = new RedirectResponse($urlRedirect);
            return $response->send();
        } else {
            return $this->redirect('<front>');
        }
    }


}
