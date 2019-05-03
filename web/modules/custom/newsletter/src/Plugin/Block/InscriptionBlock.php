<?php
namespace Drupal\newsletter\Plugin\Block;


use Drupal\Core\Block\BlockBase;

/**
 * @Block(
 *   id = "inscription_block",
 *   admin_label = @Translation("Inscription newsletter"),
 *   category = @Translation("Newsletter")
 * )
 */
class InscriptionBlock extends BlockBase
{
    protected $company;

    public function __construct(array $configuration, $plugin_id, $plugin_definition)
    {
        parent::__construct($configuration, $plugin_id, $plugin_definition);
        $this->company = \Drupal::config('system.site')->get('name');
    }

    /**
     * {@inheritdoc}
     */
    public function build()
    {
        switch (strtolower($this->company)) {
            case "turbocar":
                $myForm = \Drupal::formBuilder()->getForm('Drupal\newsletter\Form\Company\TurbocarForm');
                break;
            case "yliades":
                $myForm = \Drupal::formBuilder()->getForm('Drupal\newsletter\Form\Company\YliadesForm');
                break;
            case "blog-sitram":
                $myForm = \Drupal::formBuilder()->getForm('Drupal\newsletter\Form\Company\BlogSitramForm');
                break;
            case "comptoirdefamille":
                $myForm = \Drupal::formBuilder()->getForm('Drupal\newsletter\Form\Company\ComptoirDeFamilleForm');
                break;
        }

        $array = array(
            '#theme' => "inscription",
            '#form' => $myForm
        );

        return $array;
    }
}