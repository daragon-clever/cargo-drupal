<?php

namespace Drupal\newsletter\Form\Company;


use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\newsletter\Controller\Company\ComptoirDeFamilleController;

class ComptoirDeFamilleForm extends FormBase
{

    /**
     * {@inheritdoc}
     */
    public function getFormId()
    {
        return 'comptoir-de-famille-newsletter';
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(array $form, FormStateInterface $form_state)
    {
        $form['#action'] = "comptoir-de-famille-newsletter";

        $form['mail'] = [
            '#type' => 'email',
            '#placeholder' => $this->t("Enter your e-mail address"),
            '#required' => TRUE
        ];

        $form['captcha'] = [
            '#type' => 'captcha',
            '#captcha_type' => 'recaptcha/reCAPTCHA'
        ];

        $form['actions'] = [
            '#type' => 'actions',
            'submit' => [
                '#type' => 'submit',
                '#value' => $this->t('Send')
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
    }

    /**
     * {@inheritdoc}
     */
    public function submitForm(array &$form, FormStateInterface $form_state)
    {
        $email = $form_state->getValue('mail');
        $data = [
            'email' => $email,
            'active' => 1,
            'exported' => 0
        ];

        $base = new ComptoirDeFamilleController();
        $return = $base->doAction($data);
//        $base->savePeopleInActito($data);//à activer à mon retour une fois les tests refait et fonctionnels

        \Drupal::messenger()->addMessage($return['msg'], $return['type']);
    }
}