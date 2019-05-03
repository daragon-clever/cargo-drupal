<?php

namespace Drupal\newsletter\Form\Company;


use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\newsletter\Controller\Company\ComptoireDeFamilleController;

class ComptoireDeFamilleForm extends FormBase
{

    /**
     * {@inheritdoc}
     */
    public function getFormId()
    {
        return 'comptoire-de-famille-newsletter';
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(array $form, FormStateInterface $form_state)
    {
        $form['mail'] = [
            '#type' => 'email',
            '#placeholder' => $this->t("Enter your e-mail address"),
            '#required' => TRUE
        ];

        $form['captcha'] = array (
            '#type' => 'captcha',
            '#captcha_type' => 'recaptcha/reCAPTCHA'
        );

        $form['actions'] = [
            '#type' => 'actions',
            'submit' => array(
                '#type' => 'submit',
                '#value' => $this->t('Send')
            )
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
            $form_state->setErrorByName('mail', $this->t('Email is required'));//todo : à traduire
        } elseif (!\Drupal::service('email.validator')->isValid($mail)) {
            $form_state->setErrorByName('mail', $this->t('Email is malformed'));//todo : à traduire
        }
    }

    /**
     * {@inheritdoc}
     */
    public function submitForm(array &$form, FormStateInterface $form_state)
    {
        $email = $form_state->getValue('mail');
        $data = array(
            'email' => $email,
            'active' => 1,
            'exported' => 0
        );

        $base = new ComptoireDeFamilleController();
        $return = $base->doAction($data);

        \Drupal::messenger()->addMessage($return['msg'], $return['type']);//ajouter style class contentinfo for sucess response
    }
}