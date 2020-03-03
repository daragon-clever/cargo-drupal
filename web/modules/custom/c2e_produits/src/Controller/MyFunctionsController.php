<?php
namespace Drupal\c2e_produits\Controller;


use Drupal\Core\Controller\ControllerBase;

class MyFunctionsController extends ControllerBase
{
    public const KEY_SKU = "sku";
    public const KEY_DESC = "desc";
    public const FILENAME_PRODUCTS = "ARTICLES_WEB.CSV";

    public $filesPath;
    public $csvFile;
    public $imgPath;

    public function __construct()
    {
        $this->filesPath = \Drupal::service('file_system')->realpath(file_default_scheme() . "://");
        $this->csvFile = $this->filesPath.'/datacsv/'.self::FILENAME_PRODUCTS;
        $this->imgPath = $this->filesPath.'/dataimages/';
    }

    public function getCsvContent(): array
    {
        $arr = [];
        $allWeek = ["S0","S1","S2","S3"];

        $handle = fopen($this->csvFile, "r");
        if ($handle) {
            while (($line = fgets($handle)) !== false) {
                $explode = explode(';',$line);
                $sku = trim($explode[0]);
                $week = strtoupper(trim($explode[1]));
                $desc = trim($explode[2]);

                if (in_array($week, $allWeek)) {
                    $arr[$week][] = [
                        self::KEY_SKU => $sku,
                        self::KEY_DESC => $desc
                    ];
                }
            }
            fclose($handle);
        }

        return $arr;
    }

    public function getPictureFileNameOfSku(string $sku): string
    {
        $filenameEmb = $sku."_EMB_BD.jpg";
        $filenameDeb = $sku."_DEB_BD.jpg";

        $return = "";
        if (file($this->imgPath.$filenameDeb)) {
            $return = $filenameDeb;
        } elseif (file($this->imgPath.$filenameEmb)) {
            $return = $filenameEmb;
        }

        return $return;
    }
}