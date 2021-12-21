<?php

namespace Drupal\newsletter\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\newsletter\Profile\MerchCieProfile;

class MerchCieForm extends AbstractForm
{
    public function getFormId()
    {
        return 'merchcie-newsletter';
    }

    public function buildForm(array $form, FormStateInterface $form_state)
    {
        $form = parent::buildForm($form, $form_state);

        $form['email']['#placeholder'] = $this->t('Email address') . ' *';
        $form['email']['#attributes'] = [
            'class' => ['w-100']
        ];
        $form['nom'] = [
            '#type' => 'textfield',
            '#placeholder' => $this->t('Lastname') . ' *',
            '#required' => TRUE,
            '#attributes' => [
                'class' => ['w-100']
            ]
        ];
        $form['prenom'] = [
            '#type' => 'textfield',
            '#placeholder' => $this->t('Firstname') . ' *',
            '#required' => TRUE,
            '#attributes' => [
                'class' => ['w-100']
            ]
        ];
        $form['societe'] = [
            '#type' => 'textfield',
            '#placeholder' => $this->t('Company'),
            '#attributes' => [
                'class' => ['w-100']
            ]
        ];
        $form['rgpd_allow'] = [
            '#type' => 'checkbox',
            '#title' => '',
            '#description' => ' '
        ];
        $form['actions']['submit']['#value'] = $this->t("I subscribe");
        $form['actions']['submit']['#attributes'] = [
            'class' => ['cta', 'bg-color2', 'text-white']
        ];

        return $form;
    }

    public function validateForm(array &$form, FormStateInterface $form_state)
    {
        parent::validateForm($form, $form_state);

        $lastName = $form_state->getValue('nom');
        if (is_null($lastName) || empty($lastName)) {
            $form_state->setError($form['nom'], $this->t("Lastname is required"));
        }

        $firstName = $form_state->getValue('prenom');
        if (is_null($firstName) || empty($firstName)) {
            $form_state->setError($form['prenom'],  $this->t("Firstname is required"));
        }

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

        $return['nom'] = $form_state->getValue('nom');
        $return['prenom'] = $form_state->getValue('prenom');
        $return['societe'] = $form_state->getValue('societe');

        return $return;
    }

    protected function initProfile()
    {
        return new MerchCieProfile();
    }
}