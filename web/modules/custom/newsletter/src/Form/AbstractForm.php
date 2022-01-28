<?php

namespace Drupal\newsletter\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\newsletter\Event\NewsletterSaveEvent;
use Drupal\newsletter\Profile\BaseProfile;
use Drupal\newsletter\Profile\ProfileInterface;

abstract class AbstractForm extends FormBase
{
    protected const TYPE_MSG_STATUS = "status";

    public function getFormId()
    {
        return "newsletter-form";
    }

    public function buildForm(array $form, FormStateInterface $form_state)
    {
        $form['email'] = [
            '#type' => 'email',
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
                '#value' => $this->t('Sign up')
            ]
        ];

        return $form;
    }

    public function validateForm(array &$form, FormStateInterface $form_state)
    {
        parent::validateForm($form, $form_state);

        $email = $form_state->getValue('email');
        if (is_null($email) || empty($email)) {
            $form_state->setError($form['email'], $this->t('Email is required'));
        } elseif (!\Drupal::service('email.validator')->isValid($email)) {
            $form_state->setError($form['email'], $this->t('Email is malformed'));
        }
    }

    public function submitForm(array &$form, FormStateInterface $form_state)
    {
        $txtReturn = $this->submitProcess($form_state);

        \Drupal::messenger()->addMessage($txtReturn, self::TYPE_MSG_STATUS);
    }

    /**
     * @param FormStateInterface $form_state
     * @return array|null
     */
    protected function formatReceivedData(FormStateInterface $form_state): ?array
    {
        return [
            'email' => $form_state->getValue('email')
        ];
    }

    protected function initProfile()
    {
        return new BaseProfile();
    }

    /**
     * @param $form_state
     * @return string
     */
    protected function submitProcess($form_state): string
    {
        $data = $this->formatReceivedData($form_state); //format form data

        /** @var ProfileInterface $profile */
        $profile = $this->initProfile(); //init company profile
        $profile->saveNewsletterContact($data); //save subscriber on db

        $txtReturn = $profile->getTxtReturn(); //return txt to display

        return $txtReturn;
    }
}