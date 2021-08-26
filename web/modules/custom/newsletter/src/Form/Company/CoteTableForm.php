<?php

namespace Drupal\newsletter\Form\Company;


use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\newsletter\Controller\Company\CoteTableController;

class CoteTableForm extends FormBase
{
    /**
     * {@inheritdoc}
     */
    public function getFormId()
    {
        return 'cote-table-newsletter';
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(array $form, FormStateInterface $form_state)
    {
        $form['mail'] = [
            '#type' => 'email',
            '#placeholder' => $this->t("E-mail address"),
            '#required' => TRUE
        ];

        $form['rgpd_allow'] = [
            '#type' => 'checkbox',
            '#title' => '',
            '#description' => "<div>En renseignant ces informations j’accepte de recevoir chaque mois, la lettre
                                    d’information de Côté Table et je confirme avoir pris connaissance de la
                                    <a href='/confidentialite'>politique de confidentialité</a>.</div>"
        ];

        $form['captcha'] = [
            '#type' => 'captcha',
            '#captcha_type' => 'recaptcha/reCAPTCHA'
        ];

        $form['actions'] = [
            '#type' => 'actions',
            'submit' => [
                '#type' => 'submit',
                '#value' => $this->t('Sign up')
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

        $rgpdAllow = $form_state->getValue('rgpd_allow');
        if ($rgpdAllow !== 1) {
            $form_state->setError($form['rgpd_allow'], 'Veuillez cochez la case');
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
        ];

        $controllerBase = new CoteTableController();
        $returnMsg = $controllerBase->doAction($data);

        \Drupal::messenger()->addMessage($returnMsg['msg'], $returnMsg['type']);
    }
}