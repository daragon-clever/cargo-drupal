<?php

namespace Drupal\newsletter\Form\Company;


use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\newsletter\Controller\Company\YliadesController;
use Drupal\newsletter\Controller\NewsletterController;

class YliadesForm extends FormBase
{

    /**
     * {@inheritdoc}
     */
    public function getFormId()
    {
        return 'yliades-newsletter';
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(array $form, FormStateInterface $form_state)
    {
        //Les marques
        $marques = [
            YliadesController::MARQUE_ALL => $this->t("All the brands"),
            YliadesController::MARQUE_SEMA_DESIGN => $this->t("Sema Design"),
            YliadesController::MARQUE_COMPTOIR_DE_FAMILLE => $this->t("Comptoir de Famille"),
            YliadesController::MARQUE_COTE_TABLE => $this->t('Côté Table'),
            YliadesController::MARQUE_GENEVIEVE_LETHU => $this->t("Geneviève Lethu"),
            YliadesController::MARQUE_JARDIN_D_ULYSSE => $this->t("Jardin d'Ulysse"),
        ];

        //My Form
        $form = [
            'marques' => [
                '#type' => 'checkboxes',
                '#options' => $marques
            ],
            'mail' => [
                '#type' => 'email',
                '#placeholder' => $this->t("Enter your e-mail address"),
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
                    '#value' => $this->t('Send')
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
        $brands = $brands = $form_state->getValue('marques');
        if (is_null($mail) || empty($mail)) {
            $form['msg'] = $this->t('Email is required');
        } elseif (!\Drupal::service('email.validator')->isValid($mail)) {
            $form['msg'] = $this->t('Email is malformed');
        }

        if (empty(array_filter($brands))) {
            $form_state->setErrorByName('marques', $this->t('Brands is required'));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function submitForm(array &$form, FormStateInterface $form_state)
    {
        $email = $form_state->getValue('mail');
        $brands = $form_state->getValue('marques');

        $data = array(
            'email' => $email,
            'brands' => $brands,
            'active' => 1,
            'exported' => 0
        );

        $base = new YliadesController();
        $return = $base->doAction($data);

        \Drupal::messenger()->addMessage($return['msg'], $return['type']);
    }
}