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
use Symfony\Component\HttpFoundation\Response;

class ResultController extends ControllerBase

{
    protected $config;


    public function __construct()
    {
        $this->config = new \Drupal\recherchePdf\Config\ConfigFile();

    }

    public function getPdf(Request $request)
    {
        $refProduit = $request->request->get('refProduit');
        $lotProduit = $request->request->get('lotProduit');

        $path = $this->getPdfByRefOrLot($refProduit, $lotProduit);
        $url = $this->config::URL_SITE . "/" . $this->config::DEFAULT_PDF . "/" . $this->config::DEFAULT_LG . "/" . $this->config::DEFAULT_DIR . "/" . $path[0]->name_fic;
        $bool = $this->is_url_exist($url);
        if ($bool) {
            return new JsonResponse($url, 200, ['Content-Type' => 'application/json']);
        } else {
            return new Response("false");
        }

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
}