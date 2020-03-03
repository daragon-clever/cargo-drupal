<?php
namespace Drupal\c2e_produits\Controller;

use Drupal\Core\Controller\ControllerBase;

class FluxRssController extends ControllerBase
{
    private $urlC2E;
    private $urlArrivagesC2E;

    private $helperFct;

    public function __construct()
    {
        $this->urlC2E = \Drupal::request()->getSchemeAndHttpHost();
        $this->urlArrivagesC2E = $this->urlC2E."/arrivages";
        $this->helperFct = new MyFunctionsController();
    }

    public function generateFlux(): void
    {
        $this->generateFileRss("S0");
        $this->generateFileRss("S1");
    }

    public function generateFileRss(string $week): void
    {
        $filePath = $this->helperFct->filesPath.'/xml-flux-rss/';
        $fileNameXml = strtolower($week).".xml";

        $mainNode = new \XMLWriter();
        $mainNode->openMemory();
        $mainNode->setIndent(true);
        $mainNode->setIndentString('    ');
        $mainNode->startDocument('1.0', 'UTF-8');

        $mainNode->startElement('rss');
        $mainNode->writeAttribute('version', '2.0');
        $mainNode->startElement('channel');
        $mainNode->writeElement('title', 'Cest2euros');
        $mainNode->writeElement('link', $this->urlC2E);
        $mainNode->writeElement('description', $week);

        $csvSkuContent = $this->helperFct->getCsvContent();
        $productOfWeek = $csvSkuContent[strtoupper($week)];

        $picturesPath = file_url_transform_relative(file_create_url(file_default_scheme()."://")).'dataimages/';
        foreach ($productOfWeek as $product) {
            $skuProduct = $product[$this->helperFct::KEY_SKU];
            $descProduct = !empty($product[$this->helperFct::KEY_DESC]) ? $product[$this->helperFct::KEY_DESC] : $skuProduct;

            $pictureOfSku = $this->helperFct->getPictureFileNameOfSku($skuProduct);

            $mainNode->startElement('item');
            $mainNode->writeElement('title', 'Article '.$skuProduct);
            $mainNode->writeElement('description', $descProduct);
            $mainNode->writeElement('link', $this->urlArrivagesC2E);
            $mainNode->startElement('enclosure');
            $mainNode->writeAttribute('url', $this->urlC2E.$picturesPath.$pictureOfSku);
            $mainNode->writeAttribute('length', 112893);
            $mainNode->writeAttribute('type', 'image/jpg');
            $mainNode->endElement();
            $mainNode->endElement();
        }
        $mainNode->endElement();
        $mainNode->endElement();

        $resultXml = $mainNode->outputMemory();
        file_put_contents($filePath . $fileNameXml, $resultXml);
    }
}