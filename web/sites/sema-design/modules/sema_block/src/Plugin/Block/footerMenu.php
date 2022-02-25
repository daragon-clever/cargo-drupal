<?php

namespace Drupal\sema_block\Plugin\Block;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Session\AccountInterface;

/**
 * Provides a block with a simple text.
 *
 * @Block(
 *   id = "menu_footer",
 *   admin_label = @Translation("Social and links menu"),
 * )
 */
class footerMenu extends BlockBase {
  /**
   * {@inheritdoc}
   */
  public function build() {
    $datas = [];

    return [
      '#theme' => 'sema_block__menu_footer',
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
