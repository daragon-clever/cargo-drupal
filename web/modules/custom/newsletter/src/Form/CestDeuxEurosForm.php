<?php

namespace Drupal\newsletter\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\newsletter\Helper\DataFormatHelper;
use Drupal\newsletter\Profile\CestDeuxEurosProfile;

class CestDeuxEurosForm extends AbstractForm
{
    public function getFormId()
    {
        return 'cestdeuxeuros-newsletter';
    }

    public function buildForm(array $form, FormStateInterface $form_state)
    {
        $form = parent::buildForm($form, $form_state);

        $form['email']['#placeholder'] = "Email *";
        $form['nom'] = [
            '#type' => 'textfield',
            '#placeholder' => $this->t('Lastname') . ' *',
            '#required' => TRUE
        ];
        $form['prenom'] = [
            '#type' => 'textfield',
            '#placeholder' => $this->t('Firstname') . ' *',
            '#required' => TRUE
        ];
        $form['mobile'] = [
            '#type' => 'textfield',
            '#placeholder' => $this->t('Mobile phone') . ' *',
            '#required' => TRUE
        ];
        $form['rgpd_allow'] = [
            '#type' => 'checkbox',
            '#title' => ''
        ];
        $form['actions']['submit']['#value'] = $this->t("I sign up");

        return $form;
    }

    public function validateForm(array &$form, FormStateInterface $form_state)
    {
        parent::validateForm($form, $form_state);

        $lastName = $form_state->getValue('nom');
        if(is_null($lastName) || empty($lastName)) {
            $form_state->setError($form['nom'], $this->t("Lastname is required"));
        }

        $firstName = $form_state->getValue('prenom');
        if(is_null($firstName) || empty($firstName)) {
            $form_state->setError($form['prenom'], $this->t("Firstname is required"));
        }

        $mobilePhone = $form_state->getValue('mobile');
        if(is_null($mobilePhone) || empty($mobilePhone)) {
            $form_state->setError($form['mobile'], $this->t("Phone number is required"));
        } elseif(!DataFormatHelper::isMobilePhone($mobilePhone)) {
            $form_state->setError($form['mobile'], $this->t("Phone number is malformed"));
        }

        $rgpdAllow = $form_state->getValue('rgpd_allow');
        if($rgpdAllow !== 1) {
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

        $return['nom'] = $form_state->getValue('nom');
        $return['prenom'] = $form_state->getValue('prenom');
        $return['mobile'] = $form_state->getValue('mobile');

        return $return;
    }

    protected function initProfile()
    {
        return new CestDeuxEurosProfile();
    }
}