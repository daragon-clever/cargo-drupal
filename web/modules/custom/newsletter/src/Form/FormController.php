<?php

namespace Drupal\newsletter\Form;

use Drupal\newsletter\Config\NewsletterInitConfig;

class FormController extends NewsletterInitConfig
{
    public function getForm()
    {
        switch ($this->currentSitename) {
            case self::SITENAME_C2E:
                $form = \Drupal::formBuilder()->getForm(CestDeuxEurosForm::class);
                break;
            case self::SITENAME_CDF:
                $form = \Drupal::formBuilder()->getForm(ComptoirDeFamilleForm::class);
                break;
            case self::SITENAME_COTE_TABLE:
                $form = \Drupal::formBuilder()->getForm(CoteTableForm::class);
                break;
            case self::SITENAME_MERCHCIE:
                $form = \Drupal::formBuilder()->getForm(MerchCieForm::class);
                break;
            case self::SITENAME_SITRAM:
                $form = \Drupal::formBuilder()->getForm(SitramForm::class);
                break;
            case self::SITENAME_YLIADES:
                $form = \Drupal::formBuilder()->getForm(YliadesForm::class);
                break;
            default:
                $form = null;
        }
        return $form;
    }
}