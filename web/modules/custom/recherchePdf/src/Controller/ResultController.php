<?php
/**
 * Created by PhpStorm.
 * User: abh
 * Date: 27/04/2018
 * Time: 13:55
 */

namespace Drupal\recherchePdf\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Request;

class ResultController extends ControllerBase

{
    public function getPdf(Request $request)
    {

        //$build['test'] = ['#markup' => $request->query->get('result_pdf')];

        return array(
            '#theme' => 'resultat',
            //'#texte' => $this->t('Hello world !'),
            '#fiche_pdf' => $request->query->get('fiche_pdf')
        );

    }
}