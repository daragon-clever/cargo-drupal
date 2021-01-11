<?php

namespace Drupal\newsletter\Form\Company;


use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\HtmlCommand;
use Drupal\Core\Ajax\InvokeCommand;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\newsletter\Controller\AbstractCompanyController;
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
                '#title' => $this->t('Your Name').' *',
                '#placeholder' => $this->t('Enter your name'),
                '#required' => TRUE
            ],
            'prenom' => [
                '#type' => 'textfield',
                '#title' => $this->t('Your Firstname').' *',
                '#placeholder' => $this->t('Enter your firstname'),
                '#required' => TRUE
            ],
            'mail' => [
                '#type' => 'email',
                '#title' => $this->t('Your e-mail address').' *',
                '#placeholder' => $this->t('Enter your e-mail address'),
                '#required' => TRUE
            ],
            'captcha' => [
                '#type' => 'captcha',
                '#captcha_type' => 'recaptcha/reCAPTCHA'
            ],
            'submit' => [
                '#type' => 'button',
                '#value' => $this->t('Sign up'),
                '#ajax' => [
                    'callback' => '::myAjaxResult',
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
        //do nothing bc it's an ajax form
    }

    public function myAjaxResult(array &$form, FormStateInterface $form_state)
    {
        $response = new AjaxResponse();

        $errors = $form_state->getErrors();
        if (empty($errors)) {
            //success form content
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

            if (isset($returnMsg['type']) && $returnMsg['type'] != AbstractCompanyController::TYPE_MSG_ERROR) {
                $response->addCommand(new InvokeCommand('.js-hidden-part', 'removeClass', ['show']));
                $response->addCommand(new InvokeCommand('.result-message', 'addClass', ['success']));
            }
        } else {
            $returnMsg['msg'] = implode($errors, ', ');
        }

        $response->addCommand(
            new HtmlCommand('.result-message', $returnMsg['msg'])
        );

        $response->addCommand(new InvokeCommand(NULL, 'myCustomReloadReCatpcha'));

        return $response;
    }
}