<?php
namespace Drupal\newsletter\Controller;

use Drupal\newsletter\Form\Company as CompanyForm;

class NewsletterController
{
    protected $company;

    public function __construct()
    {
        $this->company = \Drupal::config('system.site')->getOriginal("name", false);
    }

    public function displayForm(): array
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
        }
        if (isset($myForm)) {
            $build['#form'] = $myForm;
        } else {
            $build['#msg'] = $this->t("Pas de formulaire newsletter pour ce site");//todo: à traduire
        }
        $build['#theme'] = 'inscription';

        return $build;
    }
}