<?php

namespace Drupal\recherche_pdf\Controller;

use Symfony\Component\HttpFoundation\Request;

class PdfList extends AbstractPdfAction
{
    public function displayPdfList(Request $request)
    {
        $return['#theme'] = 'pdf-list--page';

        try {
            $this->validateReceivedData($request);

            $pdfFiles = $this->getPdfFiles();

            $return['#pdfFiles'] = $pdfFiles;
        } catch (\Exception $e) {
            \Drupal::logger('recherche_pdf')->notice($e->getMessage());
            $this->displayInfoMessage($e->getMessage());
            return $this->redirectPreviousPage();
        }

        return $return;
    }
}