<?php
namespace Drupal\newsletter\Controller;

use Drupal\newsletter\Form\Company as CompanyForm;

class NewsletterController
{
    public static function displayForm(): array
    {
        $company = \Drupal::config('system.site')->getOriginal("name", false);
        $cleanCompany = strtolower(str_replace(' ', '', $company));
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
        }
        $build['#theme'] = 'inscription';

        return $build;
    }
}