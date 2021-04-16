<?php

namespace Drupal\newsletter\Form\Company;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\newsletter\Controller\Company\MerchCieController;

class MerchCieForm extends FormBase
{
    /**
     * {@inheritdoc}
     */
    public function getFormId()
    {
        return 'merchcie-newsletter';
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(array $form, FormStateInterface $form_state)
    {
        $form = [
            'nom' => [
                '#type' => 'textfield',
                '#placeholder' => 'Nom *',
                '#required' => TRUE,
                '#attributes' => [
                    'class' => ['w-100']
                ]
            ],
            'prenom' => [
                '#type' => 'textfield',
                '#placeholder' => 'Prénom *',
                '#required' => TRUE,
                '#attributes' => [
                    'class' => ['w-100']
                ]
            ],
            'societe' => [
                '#type' => 'textfield',
                '#placeholder' => 'Société',
                '#attributes' => [
                    'class' => ['w-100']
                ]
            ],
            'mail' => [
                '#type' => 'email',
                '#placeholder' => 'Adresse email *',
                '#required' => TRUE,
                '#attributes' => [
                    'class' => ['w-100']
                ]
            ],
            'rgpd_allow' => [
                '#type' => 'checkbox',
                '#title' => ''
            ],
            'captcha' => [
                '#type' => 'captcha',
                '#captcha_type' => 'recaptcha/reCAPTCHA'
            ],
            'actions' => [
                '#type' => 'actions',
                'submit' => [
                    '#type' => 'submit',
                    '#value' => "Je m'abonne",
                    '#attributes' => [
                        'class' => ['cta', 'bg-color2', 'text-white']
                    ]
                ]
            ]
        ];

        return $form;
    }

    /**
     * {@inheritdoc}
     */
    public function validateForm(array &$form, FormStateInterface $form_state)
    {
        $mail = $form_state->getValue('mail');
        if (is_null($mail) || empty($mail)) {
            $form_state->setError($form['mail'], "Votre email est requis");
        } elseif (!\Drupal::service('email.validator')->isValid($mail)) {
            $form_state->setError($form['mail'], "L'email ne semble pas valide");
        }

        $lastName = $form_state->getValue('nom');
        if(is_null($lastName) || empty($lastName)) {
            $form_state->setError($form['nom'], "Votre nom est requis");
        }

        $firstName = $form_state->getValue('prenom');
        if(is_null($firstName) || empty($firstName)) {
            $form_state->setError($form['prenom'], "Votre prénom est requis");
        }

        $rgpdAllow = $form_state->getValue('rgpd_allow');
        if($rgpdAllow !== 1) {
            $form_state->setError($form['rgpd_allow'], 'Veuillez cochez la case');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function submitForm(array &$form, FormStateInterface $form_state)
    {
        $lastName = $form_state->getValue('nom');
        $firstName = $form_state->getValue('prenom');
        $company = $form_state->getValue('societe');
        $email = $form_state->getValue('mail');

        //data for database and actito
        $data = [
            'nom' => $lastName,
            'prenom' => $firstName,
            'societe' => $company,
            'email' => $email
        ];

        //Call controller of Yliades to execute action
        $controllerBase = new MerchCieController();
        $returnMsg = $controllerBase->doAction($data);

        \Drupal::messenger()->addMessage($returnMsg['msg'], $returnMsg['type']);
    }
}