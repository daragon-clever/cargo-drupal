<?php
namespace Drupal\newsletter\Plugin\Block;


use Drupal\Core\Block\BlockBase;
use Drupal\newsletter\Form\Company as CompanyForm;

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
        $this->company = \Drupal::config('system.site')->getOriginal("name", false);
    }

    /**
     * Load template of form according to company
     *
     * {@inheritdoc}
     */
    public function build()
    {
        $cleanCompany = strtolower(str_replace(' ', '', $this->company));
        switch ($cleanCompany) {
            case "yliades":
                $myForm = \Drupal::formBuilder()->getForm(CompanyForm\YliadesForm::class);
                break;
            case "blog.sitram.fr":
                $myForm = \Drupal::formBuilder()->getForm(CompanyForm\BlogSitramForm::class);
                break;
            case "comptoirdefamille":
                $myForm = \Drupal::formBuilder()->getForm(CompanyForm\ComptoirDeFamilleForm::class);
                break;
            case "c'estdeuxeuros":
                $myForm = \Drupal::formBuilder()->getForm(CompanyForm\CestDeuxEurosForm::class);
                break;
        }

        $array = [
            '#theme' => "inscription",
            '#form' => $myForm
        ];

        return $array;
    }
}