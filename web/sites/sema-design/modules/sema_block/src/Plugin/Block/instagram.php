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
 *   id = "sema_instagram",
 *   admin_label = @Translation("Sema-Design Block Instagram"),
 * )
 */

class instagram extends BlockBase {
  /**
   * {@inheritdoc}
   */
  public function build() {
    $datas = [];

    $myConfigPage = \Drupal\config_pages\Entity\ConfigPages::config('instagram');
    if (!empty($myConfigPage)) {
      $posts = $myConfigPage->get('field_paragraph_post_instagram')->getValue();
      foreach ($posts as $index => $item) {
        $datas['insta'][] = entity_view(\Drupal\paragraphs\Entity\Paragraph::load( $item['target_id'] ), 'default');
      }
      $datas['title'] = $myConfigPage->get('field_title')->value;
      $datas['cta_link'] = $myConfigPage->get('field_cta')->uri;
      $datas['cta'] = $myConfigPage->get('field_cta')->title;
    }

    return [
      '#theme' => 'sema_block__instagram',
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
