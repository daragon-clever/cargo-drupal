<?php

namespace Drupal\recherche_pdf\Controller;

use Drupal\recherche_pdf\Helper\PdfDownload as PdfDownloadHelper;
use Drupal\recherche_pdf\Helper\PdfSearch;
use Symfony\Component\HttpFoundation\Request;

class PdfDownload extends AbstractPdfAction
{
    public function searchAndDownload(Request $request)
    {
        try {
            $this->validateReceivedData($request);

            $pdfFiles = $this->getPdfFiles();

            $dlFilesReturn = $this->downloadFiles($pdfFiles);
            \Drupal::logger('recherche_pdf')->notice('Fichier téléchargé avec succès. Entité : '
                .$this->entityKey.'. Sku : '.$this->sku.". Lot : ".$this->lot);
            return $dlFilesReturn;
        } catch (\Exception $e) {
            \Drupal::logger('recherche_pdf')->notice($e->getMessage());
            $this->displayInfoMessage($e->getMessage());
            return $this->redirectPreviousPage();
        }
    }

    public function download(Request $request)
    {
        try {
            $formatDataToDl[] = [
                PdfSearch::PDF_NAME_KEY => $request->get('name'),
                PdfSearch::PDF_URL_KEY => $request->get('url'),
            ];
            return $this->downloadFiles($formatDataToDl);
        } catch (\Exception $e) {
            \Drupal::logger('recherche_pdf')->notice($e->getMessage());
            $this->displayInfoMessage($e->getMessage());
            return $this->redirectPreviousPage();
        }

    }

    /**
     * @param $pdfFiles
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    private function downloadFiles($pdfFiles)
    {
        if (!empty($pdfFiles)) {
            $pdfDl = new PdfDownloadHelper($pdfFiles, $this->sku);
            $dl = $pdfDl->dowloadPdf();
            return $dl;
        }
    }
}