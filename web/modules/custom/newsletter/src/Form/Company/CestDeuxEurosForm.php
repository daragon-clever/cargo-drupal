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
                '#placeholder' => $this->t("Lastname"),//todo: possible en css d'ajouter une * après le placeholder ?
                '#required' => TRUE
            ],
            'prenom' => [
                '#type' => 'textfield',
                '#placeholder' => $this->t("Firstname"),//todo: possible en css d'ajouter une * après le placeholder ?
                '#required' => TRUE
            ],
            'cp' => [
                '#type' => 'textfield',
                '#placeholder' => $this->t("Zip code"),//todo: possible en css d'ajouter une * après le placeholder ?
                '#required' => TRUE
            ],
            'mail' => [
                '#type' => 'email',
                '#placeholder' => $this->t("Email"),//todo: possible en css d'ajouter une * après le placeholder ?
                '#required' => TRUE
            ],
            'newsletter' => [
                '#type' => 'checkbox',
                '#title' => $this->t("La newsletter des magasins C’est deux euros") //todo: à traduire
            ],
            'offres' => [
                '#type' => 'checkbox',
                '#title' => $this->t("Les offres promotionnelles de nos partenaires susceptibles de vous intéresser") //todo: à traduire
            ],
//            'captcha' => [
//                '#type' => 'captcha',
//                '#captcha_type' => 'recaptcha/reCAPTCHA'
//            ],
            'actions' => [
                '#type' => 'actions',
                'submit' => [
                    '#type' => 'submit',
                    '#value' => $this->t('I subscribe') //todo: trad -> Je m'inscris + mettre en uppercase en css
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
        /*voir si mail et prenom et non et cp vide ça marche*/
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

        $zipCode = $form_state->getValue('cp');
        if(is_null($zipCode) || empty($zipCode)) {
            $form_state->setError($form['cp'], $this->t('Zip code is required'));
        } elseif(is_null($this->testZipCode($zipCode))) {
            $form_state->setError($form['cp'], $this->t('Zip code is malformed'));
        }

        $newsletterShop = $form_state->getValue('newsletter');
        $offers = $form_state->getValue('offres');
        if(!($newsletterShop === 1 || $offers === 1)) {
            $form_state->setError($form['newsletter'], $this->t('Chochez au moins une des deux cases'));//todo: à traduire
        }
    }

    /**
     * {@inheritdoc}
     */
    public function submitForm(array &$form, FormStateInterface $form_state)
    {
        $lastName = $form_state->getValue('nom');
        $firstName = $form_state->getValue('prenom');
        $postCode = $form_state->getValue('cp');
        $email = $form_state->getValue('mail');
        $newsletterShop = $form_state->getValue('newsletter');
        $offers = $form_state->getValue('offres');

        //data for database and actito
        $data = [
            'nom' => $lastName,
            'prenom' => $firstName,
            'cp' => $postCode,
            'email' => $email,
            'newsletter' => $newsletterShop,
            'offres' => $offers,
            'active' => 1,
            'exported' => 0
        ];

        //Call controller of Yliades to execute action
        $controllerBase = new CestDeuxEurosController();
        $returnMsg = $controllerBase->doAction($data);

        \Drupal::messenger()->addMessage($returnMsg['msg'], $returnMsg['type']);
    }


    private function testZipCode($zipCode)
    {
        $cleanZipCode = str_replace(' ', '', trim($zipCode));
        $firstCharacter = substr($cleanZipCode, 0, 1);

        $zipCode = (int)$cleanZipCode;
        $numLength = strlen((string)$zipCode);
        if ($numLength === 4 && $firstCharacter == "0") {
            $returnZipCode = "0".$zipCode;
        } elseif ($numLength === 5) {
            $returnZipCode = $zipCode;
        } elseif ($numLength === 2) {
            $returnZipCode = $zipCode."000";
        } else {
            $returnZipCode = null;
        }

        return $returnZipCode;
    }
}