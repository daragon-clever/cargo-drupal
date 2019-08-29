<?php
namespace Drupal\c2e_produits\Controller;



class ProductController extends FonctionsController
{
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
}