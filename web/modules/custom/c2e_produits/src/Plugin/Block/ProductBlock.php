<?php
namespace Drupal\c2e_produits\Plugin\Block;


use Drupal\c2e_produits\Controller\ProductController;
use Drupal\Core\Access\AccessResult;
use Drupal\Core\Annotation\Translation;
use Drupal\Core\Block\Annotation\Block;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Session\AccountInterface;

/**
 * @Block(
 *   id = "c2e_products_block",
 *   admin_label = @Translation("Produits C2E"),
 *   category = @Translation("Produits C2E")
 * )
 */
class ProductBlock extends BlockBase
{
    /**
     * {@inheritdoc}
     */
    public function build()
    {
        $week = $this->configuration['week'];
        $nbProducts = $this->configuration['nbProducts'];

        $products = new ProductController();
        $productList = $products->displayProducts($week, $nbProducts);

        return [
            '#theme' => "liste",
            '#products' => $productList,
            '#nbItem' => $nbProducts
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function blockForm($form, FormStateInterface $form_state)
    {
        $form['week'] = [
            '#type' => 'textfield',
            '#title' => $this->t('Week'),
            '#description' => $this->t('S0, S1, S2, S3'),
            '#required' => TRUE
        ];
        $form['nbProducts'] = [
            '#type' => 'textfield',
            '#title' => $this->t('Number of visible products'),
            '#description' => $this->t('6 ou 8'),
            '#required' => TRUE
        ];

        return $form;
    }

    /**
     * {@inheritdoc}
     */
    public function blockSubmit($form, FormStateInterface $form_state)
    {
//        $this->configuration['my_block_settings'] = $form_state->getValue('my_block_settings');
        $this->configuration['week'] = $form_state->getValue('week');
        $this->configuration['nbProducts'] = $form_state->getValue('nbProducts');
    }
}