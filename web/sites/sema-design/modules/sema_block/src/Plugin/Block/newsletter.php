<?php

namespace Drupal\sema_block\Plugin\Block;
use Drupal\image\Entity\ImageStyle;
use Drupal\Core\Access\AccessResult;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Url;

/**
 * Provides a block with a simple text.
 *
 * @Block(
 *   id = "sema_newsletter",
 *   admin_label = @Translation("Sema-Design Block Newsletter"),
 * )
 */

class newsletter extends BlockBase {
  /**
   * {@inheritdoc}
   */
  public function build() {
    $datas = [];

    $myConfigPage = \Drupal\config_pages\Entity\ConfigPages::config('newsletter');
    if (!empty($myConfigPage)) {
      $datas['description'] = $myConfigPage->get('field_description')->value;
      $datas['title'] = $myConfigPage->get('field_title')->value;
      $datas['cta_link'] = Url::fromUri($myConfigPage->get('field_cta')->uri);
      $datas['cta'] = $myConfigPage->get('field_cta')->title;
      $datas['partnership_title'] = $myConfigPage->get('field_second_title')->value;
      $datas['logo'] = $myConfigPage->get('field_logo')->entity->url();
      $datas['background'] = ImageStyle::load('picture_full_max_w_800px_')->buildUrl($myConfigPage->get('field_visuel')->entity->getFileUri());
    }

    return [
      '#theme' => 'sema_block__newsletter',
      '#content' => $datas
    ];
  }

  /**
   * {@inheritdoc}
   */
  protected function blockAccess(AccountInterface $account) {
    return AccessResult::allowedIfHasPermission($account, 'access content');
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $config = $this->getConfiguration();

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['find_our_products'] = $form_state->getValue('my_block_settings');
  }
}
