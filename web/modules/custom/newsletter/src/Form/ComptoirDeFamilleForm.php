<?php

namespace Drupal\newsletter\Form;

use Drupal\Core\Form\FormStateInterface;

class ComptoirDeFamilleForm extends AbstractForm
{
    public function getFormId()
    {
        return 'comptoir-de-famille-newsletter';
    }

    public function buildForm(array $form, FormStateInterface $form_state)
    {
        $form = parent::buildForm($form, $form_state);

        $form['email']['#placeholder'] = $this->t("Enter your e-mail address");
        $form['actions']['submit']['#value'] = $this->t('Send');

        return $form;
    }
}