<?php

namespace Drupal\gl_core\Plugin\Block;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Session\AccountInterface;

/**
 * Provides a block with a simple text.
 *
 * @Block(
 *   id = "gl_newsletter",
 *   admin_label = @Translation("Block Newsletter"),
 * )
 */

class newsletter extends BlockBase {
  /**
   * {@inheritdoc}
   */
  public function build() {
    $datas = [];
    $myConfigPage = \Drupal\config_pages\Entity\ConfigPages::config('block_newsletter');
    if (!empty($myConfigPage)) {
      $datas['description'] = $myConfigPage->get('field_description')->value;
      $datas['title'] = $myConfigPage->get('field_title')->value;
      $datas['pinterest'] = $myConfigPage->get('field_pinterest')->uri;
      $datas['instagram'] = $myConfigPage->get('field_instagram')->uri;
      $datas['facebook'] = $myConfigPage->get('field_facebook')->uri;
      $datas['background_quote'] = $myConfigPage->get('field_background_quote')->value;
    }

    return [
      '#theme' => 'gl_core__newsletter',
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
