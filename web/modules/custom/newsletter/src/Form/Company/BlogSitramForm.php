<?php

namespace Drupal\newsletter\Form\Company;


use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\newsletter\Controller\Company\BlogSitramController;

class BlogSitramForm extends FormBase
{

    /**
     * {@inheritdoc}
     */
    public function getFormId()
    {
        return 'blog-sitram-newsletter';
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(array $form, FormStateInterface $form_state)
    {
        $form['mail'] = [
            '#type' => 'email',
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
                '#value' => $this->t('S\'abonner')
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
            $form['msg'] = $this->t('Email is required');
        } elseif (!\Drupal::service('email.validator')->isValid($mail)) {
            $form['msg'] = $this->t('Email is malformed');
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

        $base = new BlogSitramController();
        $return = $base->doAction($data);

        $searchUser = $base->getPeople($email);
        $contactIdToUse = intval($searchUser['id']);
        $contactId = str_pad($contactIdToUse, 6, "0", STR_PAD_LEFT);
        $dataForActito = array(
            'email' => $email,
            'contact_id' => "BLG-SIT_".strval($contactId),
            'newsletter' => 1,
            'source' => "blog_sitram"
        );

        $base->savePeopleInActito($dataForActito);

        \Drupal::messenger()->addMessage($return['msg'], $return['type']);
    }
}