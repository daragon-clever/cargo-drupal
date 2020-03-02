<?php
namespace Drupal\c2e_produits\Controller;


use Drupal\Core\Controller\ControllerBase;

class ProductController extends ControllerBase
{
    public const KEY_IMG_PATH = "img";

    private const KEY_ALERT_OBJ = "obj";
    private const KEY_ALERT_TXT = "txt";

    private const NB_REQUIRED_PRODUCTS = 8;
    private const EMAIL_TEAM = "poleweb@cargo-services.fr";
//    private const EMAIL_ALERT = "gel@cedif.fr,sgu@cedif.fr,a.champion@cargo-services.fr";
    private const EMAIL_ALERT = "a.beziat@cargo-services.fr"; //test mode

    private $helperFct;

    private $csvContent;
    private $lastUpdatedCsv;

    private $error = [];

    public function __construct()
    {
        $this->helperFct = new MyFunctionsController();
        $this->csvContent = $this->helperFct->getCsvContent();
        $this->lastUpdatedCsv = $this->getCsvTime();
    }

    private function getCsvTime(): string
    {
        $lastUpdatedFile = date('Y-m-d', filemtime($this->helperFct->csvFile));

        return $lastUpdatedFile;
    }

    public function check(string $week): bool
    {
        $week = strtoupper($week);

        $checkNbProducts = $this->checkNbProduct($week);
        if ($checkNbProducts === TRUE) { //check nb product
            $checkPicturesOfProducts = $this->checkPictures($week);
            if ($checkPicturesOfProducts === TRUE) { //check picture file exist
                return TRUE;
            } else {
                $this->error[] = $checkPicturesOfProducts;
            }
        } else {
            $this->error[] = $checkNbProducts;
        }

        return FALSE;
    }

    private function checkNbProduct($week)
    {
        $countNbProductInCsvContent = count($this->csvContent[$week]);
        if ($countNbProductInCsvContent < self::NB_REQUIRED_PRODUCTS) { //Missing selected products on Navision
            $nbMissingProduct = self::NB_REQUIRED_PRODUCTS - (int)$countNbProductInCsvContent;

            $strTxt = "Il manque %d produit(s) pour la semaine %s.\n "
                ."Il faut sélectionner au moins %d produits par semaine sur Navision.\n "
                ."Seulement %d produits ont été sélectionnés pour la semaine.\n";

            $obj = "Manque produit(s)";
            $txt = sprintf($strTxt, $nbMissingProduct, $week, self::NB_REQUIRED_PRODUCTS, $countNbProductInCsvContent);

            return $this->returnAlertParam($obj, $txt);
        }

        return TRUE;
    }

    private function checkPictures($week)
    {
        $productsOfTheWeek = $this->getProductsToDisplay($week, self::NB_REQUIRED_PRODUCTS);
        $missing = null;

        foreach ($productsOfTheWeek as $product) {
            if (empty($product[self::KEY_IMG_PATH])) $missing[] = $product[$this->helperFct::KEY_SKU];
        }

        if (is_null($missing)) {
            return TRUE;
        } else {
            $strTxt = "Il manque %d image(s) pour la semaine %s.\n "
                ."Il faut se tourner vers le PAO afin de voir avec eux où en est la demande.\n "
                ."Photo(s) manquante(s) : %s\n";

            $obj = "Manque image(s)";
            $txt = sprintf($strTxt, count($missing), $week, print_r($missing, true));

            return $this->returnAlertParam($obj, $txt);
        }
    }

    //Display product on template list + use to check img
    public function getProductsToDisplay(string $week, int $nbProducts): ?array
    {
        $productsOfTheWeek = $this->csvContent[strtoupper($week)]; //get sku of the given week

        $i = 0;
        foreach ($productsOfTheWeek as $product) {
            //add picture path (key img) to product array (already set : sku, desc)
            $product[self::KEY_IMG_PATH] = $this->helperFct->getPictureFileNameOfSku($product[$this->helperFct::KEY_SKU]);
            $productsToDisplay[] = $product;

            if (++$i == $nbProducts) break;
        }

        return $productsToDisplay;
    }

    private function returnAlertParam($obj, $txt): array
    {
        return [
            self::KEY_ALERT_OBJ => $obj,
            self::KEY_ALERT_TXT => $txt
        ];
    }

    public function alertTeam()
    {
        if (!empty($this->error)) {
            $objs = [];
            $txts = [];
            foreach ($this->error as $err) {
                $objs[] = $err[self::KEY_ALERT_OBJ];
                $txts[] = $err[self::KEY_ALERT_TXT];
            }

            $obj = "[C2E] ".implode(" - ",array_unique($objs));
            $msg = implode("---\n", $txts)."\nDernière mise à jour du fichier CSV : ".$this->lastUpdatedCsv;
            $to = self::EMAIL_ALERT;
            $cc = self::EMAIL_TEAM;

            $this->sendMail($obj, $msg, $to, $cc);
        }
    }

    private function sendMail($obj, $txt, $to, $cc = ""): void
    {
        if (!empty($obj) && !empty($txt)) {
            $mailManager = \Drupal::service('plugin.manager.mail');

            $module = 'c2e_produits';
            $key = 'sku_images';
            $langcode = \Drupal::currentUser()->getPreferredLangcode();

            $paramMail['cc'] = $cc;
            $paramMail['from'] = self::EMAIL_TEAM;
            $paramMail['subject'] = $obj;
            $paramMail['message'] = $txt;

            $reply = false;
            $send = true;

            $mailManager->mail($module, $key, $to, $langcode, $paramMail, $reply, $send);
        }
    }
}