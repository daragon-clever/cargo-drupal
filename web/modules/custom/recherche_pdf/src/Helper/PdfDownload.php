<?php

namespace Drupal\recherche_pdf\Helper;

use Symfony\Component\HttpFoundation\Response;

class PdfDownload
{
    /**
     * @var Array
     */
    private $files;

    /**
     * @var string|null
     */
    private $sku;

    public function __construct($filesData, $sku = null)
    {
        $this->files = $filesData;
        $this->sku = $sku;
    }

    /**
     * @return Response
     * @throws \Exception
     */
    public function dowloadPdf()
    {
        try {
            if (sizeof($this->files) > 1) {
                return $this->downloadFiles();
            } else {
                return $this->downloadFile();
            }
        } catch (\Exception $e) {
            throw new \Exception(t("Error during file download"));
        }
    }

    private function downloadFiles()
    {
        $zipName = $this->formatZipName();
        $this->convertToZipFormat($zipName);

        $response = new Response(file_get_contents($zipName));
        $response->headers->set('Content-Type', 'application/zip');
        $response->headers->set('Content-Disposition', 'attachment;filename="' . $zipName . '"');
        $response->headers->set('Content-length', filesize($zipName));

        $this->removeZipCreated($zipName);

        return $response;
    }

    public function downloadFile()
    {
        $url = $this->files[0][PdfSearch::PDF_URL_KEY];
        $filename = $this->files[0][PdfSearch::PDF_NAME_KEY];

        $response = new Response();
        $response->headers->set('Content-type', 'application/octet-stream');
        $response->headers->set('Content-Disposition', sprintf('attachment; filename="%s"', $filename));
        $response->setContent(file_get_contents($url));

        return $response;
    }

    private function formatZipName()
    {
        return 'Documents_'.$this->sku.'_'.date("Ymd-his").'.zip';
    }

    private function convertToZipFormat($zipName)
    {
        $zip = new \ZipArchive();
        $zip->open($zipName,  \ZipArchive::CREATE);
        foreach ($this->files as $file) {
            $zip->addFromString(basename($file[PdfSearch::PDF_NAME_KEY]),  file_get_contents($file[PdfSearch::PDF_URL_KEY]));
        }
        $zip->close();
    }

    private function removeZipCreated($zipName)
    {
        @unlink($zipName);
    }
}