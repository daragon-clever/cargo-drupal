<?php
namespace Drupal\c2e_produits\Controller;



class FluxRssController extends FonctionsController
{
    private $urlArrivagesC2E;

    public function __construct()
    {
        parent::__construct();
        $this->urlArrivagesC2E = $this->urlC2E."/arrivages";
    }

    public function doAction()
    {
        $this->generateFlux("S0");
        $this->generateFlux("S1");
    }

    public function generateFlux($week = "S0")
    {
        $filePath = $this->filesPath.'/xml-flux-rss/';
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

        $csvSkuContent = $this->getCsvContent();
        $skuOfWeek = $csvSkuContent[strtoupper($week)];

        $picturesPath = file_url_transform_relative(file_create_url(file_default_scheme()."://")).'dataimages/';
        foreach ($skuOfWeek as $sku) {
            $pictureOfSku = $this->getPictureFileNameOfSku($sku);

            $mainNode->startElement('item');
            $mainNode->writeElement('title', 'Article '.$sku);
            $mainNode->writeElement('description', $sku);
            $mainNode->writeElement('link', $this->urlArrivagesC2E);
            $mainNode->startElement('enclosure');
            $mainNode->writeAttribute('url', $this->urlC2E.$picturesPath.$pictureOfSku);
            $mainNode->writeAttribute('length', 112893);
            $mainNode->writeAttribute('type', 'image/jpg');
            $mainNode->endElement();
            $mainNode->endElement();
        }

        $resultXml = $mainNode->outputMemory();
        file_put_contents($filePath . $fileNameXml, $resultXml);
    }



}