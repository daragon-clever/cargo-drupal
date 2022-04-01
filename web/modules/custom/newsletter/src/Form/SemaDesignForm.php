<?php

namespace Drupal\newsletter\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\newsletter\Profile\SemaDesignProfile;

class SemaDesignForm extends AbstractForm
{
    public function getFormId()
    {
        return 'semadesign-newsletter';
    }

    public function buildForm(array $form, FormStateInterface $form_state)
    {
        $form = parent::buildForm($form, $form_state);

        $form['email']['#placeholder'] = $this->t("Your e-mail address");
        $form['rgpd_allow'] = [
            '#type' => 'checkbox',
            '#title' => '',
            '#description' => ' '
        ];
        $form['is_pro'] = [
            '#type' => 'checkbox',
            '#title' => 'Vous êtes un professionnel'
        ];
        $form['actions']['submit']['#value'] = $this->t("I sign up");

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

    /**
     * @param FormStateInterface $form_state
     * @return array|null
     */
    protected function formatReceivedData(FormStateInterface $form_state): ?array
    {
        $return = parent::formatReceivedData($form_state);

        $return['is_pro'] = $form_state->getValue('is_pro');

        return $return;
    }

    protected function initProfile()
    {
        return new SemaDesignProfile();
    }
}