<?php
/**
 * Created by PhpStorm.
 * User: abh
 * Date: 27/04/2018
 * Time: 13:55
 */

namespace Drupal\recherchePdf\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

class RechercheController extends ControllerBase

{
    protected $config;


    public function __construct()
    {
        $this->config = new \Drupal\recherchePdf\Config\ConfigFile();

    }

    public function displayForm(Request $request)
    {
        return array(
            '#theme' => 'recherche',
        );
    }
    public function getPdf(Request $request)
    {
        $refProduit = $request->get('refProduit');
        $lotProduit = $request->get('lotProduit');
        $qrcodeadm =  \Drupal::config('system.qrcodeadm')->get('soc', FALSE);
        $configQrcodeadm = false;

        $dataSoc = $this->config::QRCODEADM[$qrcodeadm];

        if($qrcodeadm != null) {
          $configQrcodeadm = true;
        }

        $return = array(
          '#theme' => 'recherche',
          '#msg' => $this->t('Une erreur système ne nous permet pas de donnée suite à votre demande.'),
        );

        $postData = [
          'RefProd' => $refProduit,
          'LotProd' => $lotProduit,
          'ID_SOC' => $dataSoc['ID_SOC'],
          'CODE_SOC' => $dataSoc['CODE_SOC'],
          'DEFAULT_PDF' => $dataSoc['DEFAULT_PDF'],
          'DEFAULT_LG' => $dataSoc['DEFAULT_LG'],
          'DEFAULT_DIR' => $dataSoc['DEFAULT_DIR'],
          'tri_soc' => $dataSoc['tri_soc'],
        ];
        if($qrcodeadm == true) {
          $rslt = $this->getPdfByRefOrLotCurl($postData);
          if ($rslt != null && $rslt->nomfic != '') {
            $url = $dataSoc['URL_SITE'] . "/" . $rslt->nomfic;
            if ($this->is_url_exist($url)) {
              return $this->headersResponse($url, $rslt->fileName);
            } else {
              $this->redirectResponse(
                  '/recherche-pdf',
                  $this->t('Fiche de données sécurité non trouvée merci de vérifier votre saisie')
              );
            }
          } else {
            $this->redirectResponse(
              '/recherche-pdf',
              $this->t('Fiche de données sécurité non trouvée merci de vérifier votre saisie')
            );
          }
        }
        return $return;
    }

    public function getPdfByRefOrLot($refProduit = '', $lotProduit = '')
    {

        // Switch to external database
        \Drupal\Core\Database\Database::setActiveConnection('QRcodeTBC');

        $db = \Drupal\Core\Database\Database::getConnection();

        // $connection = \Drupal::database();

        if ($refProduit && strlen($lotProduit == 0)) {
            $req = "select name_fic from fiches_produit where soc_id='" . $this->config::ID_SOC . "' and RefProduit='" . $refProduit . "' and LNGProduit = '" . $this->config::DEFAULT_LG . "' limit 1";
            $query = $db->query($req);
        } elseif ($lotProduit && strlen($refProduit == 0)) {
            $req = "select name_fic from fiches_produit where soc_id='" . $this->config::ID_SOC . "' and LotProduit='" . $lotProduit . "' and LNGProduit = '" . $this->config::DEFAULT_LG . "' limit 1";
            $query = $db->query($req);
        } else {
            $req = "select name_fic from fiches_produit where soc_id='" . $this->config::ID_SOC . "' and RefProduit='" . $refProduit . "' and LotProduit='" . $lotProduit . "' and LNGProduit = '" . $this->config::DEFAULT_LG . "' limit 1";
            $query = $db->query($req);
        }
        $result = $query->fetchAll();

        // Switch default database
        \Drupal\Core\Database\Database::setActiveConnection();

        return $result;
    }
    public function _getPdf(Request $request)
  {
    $refProduit = $request->get('refProduit');
    $lotProduit = $request->get('lotProduit');
    $rslt =$this->getPdfByRefOrLot($refProduit, $lotProduit);
    if (count($rslt) > 0) {
      $fileName = $rslt[0]->name_fic;

      $url = $this->config::URL_SITE . "/" . $this->config::DEFAULT_PDF . "/" . $this->config::DEFAULT_LG . "/" . $this->config::DEFAULT_DIR . "/" . $fileName;
      if ($this->is_url_exist($url)) {
        $response = new Response();
        $response->headers->set('Content-type', 'application/octet-stream');
        $response->headers->set('Content-Disposition', sprintf('attachment; filename="%s"', $fileName));
        $response->setContent(file_get_contents($url));
        $response->setStatusCode(200);
        $response->headers->set('Content-Transfer-Encoding', 'binary');
        $response->headers->set('Pragma', 'no-cache');
        $response->headers->set('Expires', '0');
        return $response;

      } else {
        return array(
          '#theme' => 'recherche',
          '#msg' => $this->t('Fiche de données sécurité non trouvée merci de vérifier votre saisie'),
        );
      }
    } else {
      return array(
        '#theme' => 'recherche',
        '#msg' => $this->t('Fiche de données sécurité non trouvée merci de vérifier votre saisie'),
      );
    }
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
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($postfields))
        );
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
      $messenger->addMessage($message,'error', TRUE);
      $redirect = new RedirectResponse($url);
      $redirect->send();
     //die();
    }

}
