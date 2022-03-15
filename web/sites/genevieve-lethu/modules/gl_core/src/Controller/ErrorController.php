<?php

/**
 * @file
 * Controller file for sema_core module.
 */
namespace Drupal\gl_core\Controller;

use Drupal\Core\Controller\ControllerBase;

class ErrorController extends ControllerBase {

  public function notFound() {
    $datas = [];
    $myConfigPage = \Drupal\config_pages\Entity\ConfigPages::config('page_404');
    if (!empty($myConfigPage)) {
      $datas['subtitle'] = $myConfigPage->get('field_subtitle')->value;
      $datas['title'] = $myConfigPage->get('field_title')->value;
      $datas['cta_link'] = $myConfigPage->get('field_cta')->uri;
      $datas['cta'] = $myConfigPage->get('field_cta')->title;
      $datas['picture'] = $myConfigPage->get('field_background')->view();
    }

    return [
      '#theme' => 'gl_core__404',
      '#content' => $datas
    ];
  }

}
