<?php

namespace Drupal\newsletter\Form\Company;


use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\newsletter\Controller\Company\SitramController;

class SitramForm extends FormBase
{
    /**
     * {@inheritdoc}
     */
    public function getFormId()
    {
        return 'sitram-newsletter';
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(array $form, FormStateInterface $form_state)
    {
        $form = [
            'nom' => [
                '#type' => 'textfield',
                '#title' => 'Votre Nom *',
                '#placeholder' => 'Saisir votre nom',
                '#required' => TRUE
            ],
            'prenom' => [
                '#type' => 'textfield',
                '#title' => 'Votre Prénom *',
                '#placeholder' => 'Saisir votre prénom',
                '#required' => TRUE
            ],
            'mail' => [
                '#type' => 'email',
                '#title' => 'Votre adresse email *',
                '#placeholder' => 'Saisir votre adresse e-mail',
                '#required' => TRUE
            ],
            'captcha' => [
                '#type' => 'captcha',
                '#captcha_type' => 'recaptcha/reCAPTCHA'
            ],
            'actions' => [
                '#type' => 'actions',
                'submit' => [
                    '#type' => 'submit',
                    '#value' => "S'inscrire",
                    '#attributes' => ['class' => ['js-show-hidden-part']]
                ],
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
            $form_state->setError($form['mail'], $this->t('Email is required'));
        } elseif (!\Drupal::service('email.validator')->isValid($mail)) {
            $form_state->setError($form['mail'], $this->t('Email is malformed'));
        }

        $lastName = $form_state->getValue('nom');
        if(is_null($lastName) || empty($lastName)) {
            $form_state->setError($form['nom'], $this->t('Lastname is required'));
        }

        $firstName = $form_state->getValue('prenom');
        if(is_null($firstName) || empty($firstName)) {
            $form_state->setError($form['prenom'], $this->t('Firstname is required'));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function submitForm(array &$form, FormStateInterface $form_state)
    {
        $email = $form_state->getValue('mail');
        $lastName = $form_state->getValue('nom');
        $firstName = $form_state->getValue('prenom');

        $data = [
            'email' => $email,
            'nom' => $lastName,
            'prenom' => $firstName,
        ];

        $controllerBase = new SitramController();
        $returnMsg = $controllerBase->doAction($data);

        \Drupal::messenger()->addMessage($returnMsg['msg'], $returnMsg['type']);
    }
}