<?php

/**
 * @file
 * Controller file for sema_core module.
 */
namespace Drupal\sema_core\Controller;

use Drupal\Core\Controller\ControllerBase;

class NewsletterController extends ControllerBase {

  public function newsletter() {
    $datas = [];

    $myConfigPage = \Drupal\config_pages\Entity\ConfigPages::config('page_newsletter');
    if (!empty($myConfigPage)) {
      $datas['description'] = $myConfigPage->get('field_description')->value;
      $datas['title'] = $myConfigPage->get('field_title')->value;
      $datas['mainPicture'] = $myConfigPage->get('field_main_visual')->view();
    }

    return [
      '#theme' => 'sema_core__newsletter',
      '#content' => $datas
    ];
  }

}
