<?php

namespace Drupal\recherche_pdf\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\recherche_pdf\Config\Config;
use Drupal\recherche_pdf\Helper\PdfSearch;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class AbstractPdfAction extends ControllerBase
{
    /**
     * @var string
     */
    protected $sku;

    /**
     * @var string
     */
    protected $lot;

    /**
     * @var string
     */
    protected $entityKey;

    /**
     * @param Request $request
     * @return bool
     * @throws \Exception
     */
    protected function validateReceivedData(Request $request)
    {
        $this->setVarsWithReceivedData($request);

        $exceptionMsg = [];

        if (empty($this->sku)) {
            $exceptionMsg[] = t("Sku is required").". ";
        }

        if ($request->get('lot_req') == '1' && empty($this->lot)) {
            $exceptionMsg[] = t("Lot is required").". ";
        }

        if (empty($this->entityKey) || !$this->isEntityExist($this->entityKey)) {
            $exceptionMsg[] = t("Configuration error").". ";
        }

        if (!empty($exceptionMsg)) {
            throw new \Exception(implode(" ", $exceptionMsg));
        }

        return TRUE;
    }

    /**
     * @return array
     * @throws \Exception
     */
    protected function getPdfFiles()
    {
        $pdfSearch = new PdfSearch($this->entityKey, $this->sku, $this->lot);
        try {
            $pdfGet = $pdfSearch->execute();
            return $pdfGet;
        } catch (\Exception $e) {
            \Drupal::logger('recherche_pdf')->notice($e->getMessage());
            throw new \Exception($e->getMessage());
        }
    }

    protected function displayInfoMessage($txt)
    {
        $messenger = \Drupal::messenger();
        $messenger->addMessage(
            t($txt),
            $messenger::TYPE_ERROR,
            true
        );
    }

    protected function redirectPreviousPage()
    {
        $url = $_SERVER["HTTP_REFERER"];
        return new RedirectResponse($url);
    }

    private function setVarsWithReceivedData(Request $request)
    {
        $this->sku = $request->get('sku');
        $this->lot = $request->get('lot');
        $this->entityKey = $request->get('entity');
    }

    private function isEntityExist()
    {
        return !is_null(Config::getQrcodeConfig($this->entityKey));
    }
}