<?php

namespace Drupal\newsletter\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\newsletter\Profile\CoteTableProfile;

class CoteTableForm extends AbstractForm
{
    public function getFormId()
    {
        return 'cote-table-newsletter';
    }

    public function buildForm(array $form, FormStateInterface $form_state)
    {
        $form = parent::buildForm($form, $form_state);

        $form['email']['#placeholder'] = $this->t("E-mail address");
        $form['rgpd_allow'] = [
            '#type' => 'checkbox',
            '#title' => '',
            '#description' => ' '
        ];

        return $form;
    }

    public function validateForm(array &$form, FormStateInterface $form_state)
    {
        parent::validateForm($form, $form_state);

        $rgpdAllow = $form_state->getValue('rgpd_allow');
        if ($rgpdAllow !== 1) {
            $form_state->setError($form['rgpd_allow'], $this->t("Check the RGPD box"));
        }
    }
}