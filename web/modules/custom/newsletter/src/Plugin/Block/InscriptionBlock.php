<?php
namespace Drupal\newsletter\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\newsletter\Form\FormController;

/**
 * @Block(
 *   id = "inscription_block",
 *   admin_label = @Translation("Cargo - Inscription newsletter"),
 *   category = @Translation("Cargo - newsletter")
 * )
 */
class InscriptionBlock extends BlockBase
{
    /**
     * Load template of form according to current website
     *
     * {@inheritdoc}
     */
    public function build()
    {
        $formController = new FormController();
        $form = $formController->getForm();

        $theme['#theme'] = "inscription";
        if (!is_null($form)) {
            $theme['#form'] = $form;
        }

        return $theme;
    }
}