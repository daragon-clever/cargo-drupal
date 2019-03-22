<?php

namespace Drupal\recherche_pdf\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Drupal\Core\Url;

class RechercheController extends ControllerBase

{
    protected $config;


    public function __construct()
    {
        $this->config = new \Drupal\recherche_pdf\Config\ConfigFile();

    }

    public function getPdf(Request $request)
    {

        $refProduit = $request->get('refProduit');
//        if (\Drupal::config('system.site')->get('name') == "turbocar")
        $lotProduit = $request->get('lotProduit');
        $qrcodeadm =  \Drupal::config('system.qrcodeadm')->get('soc', FALSE);
        $qrcodeadmProd =  \Drupal::config('system.qrcodeadm')->get('prod', FALSE);
        $qrcodeadmMail =  \Drupal::config('system.qrcodeadm')->get('mailTesterreur', FALSE);
        $configQrcodeadm = false;

        $dataSoc = $this->config::QRCODEADM[$qrcodeadm];

        if($qrcodeadm != null) {
          $configQrcodeadm = true;
        }

        $postData = [
          'RefProd' => $refProduit,
          'LotProd' => $lotProduit,
          'ID_SOC' => $dataSoc['ID_SOC'],
          'CODE_SOC' => $dataSoc['CODE_SOC'],
          'DEFAULT_PDF' => $dataSoc['DEFAULT_PDF'],
          'DEFAULT_LG' => $dataSoc['DEFAULT_LG'],
          'DEFAULT_DIR' => $dataSoc['DEFAULT_DIR'],
          'tri_soc' => $dataSoc['tri_soc'],
          'PROD' => $qrcodeadmProd,
        ];

        $paramMail['from'] = $dataSoc['EMAIL_FIC_FROM'];
        $paramMail['to'] = $qrcodeadmMail != null ? $qrcodeadmMail : implode(', ' , $dataSoc['EMAIL_FIC_TO']);
        $paramMail['fiches'] = $postData['RefProd']." ".$postData['LotProd'];

        if($qrcodeadm == true) {
          $rslt = $this->getPdfByRefOrLotCurl($postData);
          if ($rslt != null && $rslt->nomfic != '') {
            $url = $dataSoc['URL_SITE'] . "/" . $rslt->nomfic;
            if ($this->is_url_exist($url)) {
                echo "success";
              return $this->headersResponse($url, $rslt->fileName);
            } else {
              $paramMail['subject'] = "Fichier pdf introuvable - ".$paramMail['fiches'];
              $paramMail['body'] = "Le Fichier ".$rslt->fileName." pour Le produit reference ".$postData['RefProd']." lot ".$postData['LotProd']." est introuvable";
              $this->sendMailNoFile($paramMail);

              echo "error";
            }
          } else {
            $paramMail['subject'] = "Produit introuvable - ".$paramMail['fiches'];
            $paramMail['body'] = "Le produit reference ".$postData['RefProd']." lot ".$postData['LotProd']." est introuvable dans la base de données.";
            $this->sendMailNoFile($paramMail);

            echo "error";
          }
        } else {
            echo "error";
        }
        die();
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

    protected function redirectResponse($url,$message)
    {
      $messenger = \Drupal::messenger();
      $messenger->addMessage($message,'error', false);
      /*$redirect = new RedirectResponse($url);
      $redirect->send();*/
    }

    protected  function sendMailNoFile($params){

      $mailManager = \Drupal::service('plugin.manager.mail');
      $module = 'recherchePdf';
      $key = 'fiche_Pdf';
      $to = $params['to'];
      $langcode = \Drupal::currentUser()->getPreferredLangcode();

      $reply = false;
      $send = true;
      $result = $mailManager->mail($module, $key, $to, $langcode, $params, $reply, $send);
    }


}
