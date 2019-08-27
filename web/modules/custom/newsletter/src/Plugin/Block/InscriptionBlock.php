<?php
namespace Drupal\newsletter\Plugin\Block;


use Drupal\Core\Block\BlockBase;
use Drupal\newsletter\Form\Company as CompanyForm;

/**
 * @Block(
 *   id = "inscription_block",
 *   admin_label = @Translation("Inscription newsletter"),
 *   category = @Translation("Newsletter Cargo")
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
     * {@inheritdoc}
     */
    public function build()
    {
        $cleanCompany = strtolower(str_replace(' ', '', $this->company));
        switch ($cleanCompany) {
            case "yliades":
                $myForm = \Drupal::formBuilder()->getForm(CompanyForm\YliadesForm::class);
                $theme = "inscription";
                break;
            case "blog.sitram.fr":
                $myForm = \Drupal::formBuilder()->getForm(CompanyForm\BlogSitramForm::class);
                $theme = "inscription";
                break;
            case "comptoirdefamille":
                $myForm = \Drupal::formBuilder()->getForm(CompanyForm\ComptoirDeFamilleForm::class);
                $theme = "inscription";
                break;
            case "c'estdeuxeuros"://todo: déplacer block de page d'accueil node à toutes les pages
                $myForm = \Drupal::formBuilder()->getForm(CompanyForm\CestDeuxEurosForm::class);
                $theme = "inscription-block";
                break;
        }

        $array = array(
            '#theme' => $theme,
            '#form' => $myForm
        );

        return $array;
    }
}