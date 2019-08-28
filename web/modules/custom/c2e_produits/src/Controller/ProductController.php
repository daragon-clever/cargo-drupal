<?php
namespace Drupal\c2e_produits\Controller;


use Drupal\Core\Controller\ControllerBase;

class ProductController extends ControllerBase
{
    private $filesPath;

    public function __construct()
    {
        $this->filesPath = \Drupal::service('file_system')->realpath(file_default_scheme() . "://");
    }

    public function displayProducts($week, $nbProducts)
    {
        $products = $this->getCsvContent();
        $productsOfTheWeek = $products[$week];

        $i = 0;
        foreach ($productsOfTheWeek as $sku) {
            $imgsProducts[$sku] = $this->getPictureFileNameOfSku($sku);
            if (++$i == $nbProducts) break;
        }

        return $imgsProducts;
    }

    private function getCsvContent()
    {
        $ficCSV = $this->filesPath.'/datacsv/ARTICLES_WEB.CSV';
        $arr = [];

        $handle = fopen($ficCSV, "r");
        if ($handle) {
            while (($line = fgets($handle)) !== false) {
                $l=explode(';',$line);
                if (in_array(trim($l[1]), ["S0","S1","S2","S3"])) $arr[trim($l[1])][] = trim($l[0]);
            }
            fclose($handle);
        }

        return $arr;
    }

    private function getPictureFileNameOfSku($sku)
    {
        $picturesPath = $this->filesPath.'/dataimages/';

        $filenameEmb = $sku."_EMB_BD.jpg";
        $filenameDeb = $sku."_DEB_BD.jpg";

        if (file($picturesPath.$filenameDeb)) {
            $return = $filenameDeb;
        } elseif (file($picturesPath.$filenameEmb)) {
            $return = $filenameEmb;
        } else {
            $return = "";
        }

        return $return;
    }
}