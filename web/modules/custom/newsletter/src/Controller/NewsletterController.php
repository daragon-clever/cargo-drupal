<?php
namespace Drupal\newsletter\Controller;

use Drupal\newsletter\Form\Company as CompanyForm;

class NewsletterController
{
    private const SITENAME_YLIADES = "yliades";
    private const SITENAME_BLOG_SITRAM = "blog.sitram.fr";
    private const SITENAME_CDF = "comptoirdefamille";
    private const SITENAME_C2E = "c'estdeuxeuros";

    public $currentCompany;

    public function __construct()
    {
        $this->setCurrentCompany();
    }

    public function getCompanyController()
    {
        $base = null;
        switch ($this->currentCompany) {
            case self::SITENAME_YLIADES:
                $base = new Company\YliadesController();
                break;
            case self::SITENAME_BLOG_SITRAM:
                $base = new Company\BlogSitramController();
                break;
            case self::SITENAME_CDF:
                $base = new Company\ComptoirDeFamilleController();
                break;
            case self::SITENAME_C2E:
                $base = new Company\CestDeuxEurosController();
                break;
        }
        return $base;
    }

    public function getCompanyForm()
    {
        $myForm = null;
        switch ($this->currentCompany) {
            case self::SITENAME_YLIADES:
                $myForm = \Drupal::formBuilder()->getForm(CompanyForm\YliadesForm::class);
                break;
            case self::SITENAME_BLOG_SITRAM:
                $myForm = \Drupal::formBuilder()->getForm(CompanyForm\BlogSitramForm::class);
                break;
            case self::SITENAME_CDF:
                $myForm = \Drupal::formBuilder()->getForm(CompanyForm\ComptoirDeFamilleForm::class);
                break;
            case self::SITENAME_C2E:
                $myForm = \Drupal::formBuilder()->getForm(CompanyForm\CestDeuxEurosForm::class);
                break;
        }
        return $myForm;
    }

    private function setCurrentCompany()
    {
        $company = \Drupal::config('system.site')->getOriginal("name", false);
        $this->currentCompany = strtolower(str_replace(' ', '', $company));
    }
}