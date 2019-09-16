<?php
namespace Drupal\c2e_produits\Controller;


class ProductController extends FonctionsController
{
    private const NB_REQUIRED_PRODUCTS = 8;
    private const EMAIL_TEAM = "poleweb@cargo-services.fr";

    private $error = "";

    public function displayProducts(string $week, int $nbProducts): ?array
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

    public function checkProducts(): void
    {
        $csvContent = $this->getCsvContent();
        $this->setError($csvContent, 'S0');
        $this->setError($csvContent, 'S1');

        $this->alertTeam();
    }

    private function setError(array $csvContent, string $week): void
    {
        $count = count($csvContent[strtoupper($week)]);
        if ($count < self::NB_REQUIRED_PRODUCTS) {
            $missing = self::NB_REQUIRED_PRODUCTS - (int)$count;
            $textProducts = "Il manque %d produit(s) pour la semaine %s \n";
            $this->error .= sprintf($textProducts, $missing, strtoupper($week));
        }

        $listSkuWeek = array_slice($csvContent[$week], 0, self::NB_REQUIRED_PRODUCTS, true);
        foreach ($listSkuWeek as $sku) {
            $pictureFileName = $this->getPictureFileNameOfSku($sku);
            if (empty($pictureFileName)) {
                $textPicture = "Il manque l'image pour le SKU %d de la semaine %s \n";
                $this->error .= sprintf($textPicture, $sku, $week);
            }
        }
    }

    private function alertTeam(): void
    {
        if (!empty($this->error)) {
            $mailManager = \Drupal::service('plugin.manager.mail');

            $module = 'c2e_produits';
            $key = 'sku_images';
            $paramMail['to'] = self::EMAIL_TEAM;
            $langcode = \Drupal::currentUser()->getPreferredLangcode();
            $paramMail['from'] = self::EMAIL_TEAM;
            $paramMail['subject'] = "[C2E] Manque sku produits et/ou images";
            $paramMail['body'] = "";
            $reply = false;
            $send = true;

            $mailManager->mail($module, $key, $paramMail['to'], $langcode, $paramMail, $reply, $send);
        }
    }
}