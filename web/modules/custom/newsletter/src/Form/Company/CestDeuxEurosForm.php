<?php

namespace Drupal\newsletter\Form\Company;


use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\newsletter\Controller\Company\CestDeuxEurosController;

class CestDeuxEurosForm extends FormBase
{
    /**
     * {@inheritdoc}
     */
    public function getFormId()
    {
        return 'cestdeuxeuros-newsletter';
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
                '#required' => TRUE
            ],
            'prenom' => [
                '#type' => 'textfield',
                '#placeholder' => 'Prénom *',
                '#required' => TRUE
            ],
            'mobile' => [
                '#type' => 'textfield',
                '#placeholder' => 'N° de mobile *',
                '#required' => TRUE
            ],
            'mail' => [
                '#type' => 'email',
                '#placeholder' => 'Email *',
                '#required' => TRUE
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
                    '#value' => "Je m'inscris"
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

        $mobilePhone = $form_state->getValue('mobile');
        if(is_null($mobilePhone) || empty($mobilePhone)) {
            $form_state->setError($form['mobile'], "Votre n° de mobile est requis");
        } elseif(!$this->isMobilePhone($mobilePhone)) {
            $form_state->setError($form['mobile'], "Votre n° de mobile ne semble pas valide");
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
        $rgpdAllow = $form_state->getValue('rgpd_allow');
        $lastName = $form_state->getValue('nom');
        $firstName = $form_state->getValue('prenom');
        $mobile = $form_state->getValue('mobile');
        $email = $form_state->getValue('mail');
        $newsletterShop = $offers = ($rgpdAllow === 1) ? 1 : 0;

        //data for database and actito
        $data = [
            'nom' => $lastName,
            'prenom' => $firstName,
            'mobile' => $mobile,
            'email' => $email,
            'newsletter' => $newsletterShop,
            'offres' => $offers,
        ];

        //Call controller of Yliades to execute action
        $controllerBase = new CestDeuxEurosController();
        $returnMsg = $controllerBase->doAction($data);

        \Drupal::messenger()->addMessage($returnMsg['msg'], $returnMsg['type']);
    }


    private function isMobilePhone($mobilePhone)
    {
        $cleanMobilePhone = str_replace(' ', '', trim($mobilePhone));
        $mobilePhoneLength = strlen((string)$mobilePhone);
        $firstCharacters = substr($cleanMobilePhone, 0, 2);
        $firstCharacters2 = substr($cleanMobilePhone, 0, 4);
        $firstCharacters3 = substr($cleanMobilePhone, 0, 5);

        if (in_array($firstCharacters, ['06', '07']) && $mobilePhoneLength === 10
            || in_array($firstCharacters2, ['+336', '+337']) && $mobilePhoneLength === 12
            || in_array($firstCharacters3, ['+3306', '+3307']) && $mobilePhoneLength === 13) {
            return true;
        }

        return false;
    }
}