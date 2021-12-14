<?php

namespace Drupal\newsletter\Form;

use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\HtmlCommand;
use Drupal\Core\Ajax\InvokeCommand;
use Drupal\Core\Form\FormStateInterface;
use Drupal\newsletter\Profile\SitramProfile;

class SitramForm extends AbstractForm
{
    public function getFormId()
    {
        return 'sitram-newsletter';
    }

    public function buildForm(array $form, FormStateInterface $form_state)
    {
        $form = parent::buildForm($form, $form_state);
        unset($form['actions']);

        $form['email']['#title'] = $this->t('Your e-mail address').' *';
        $form['email']['#placeholder'] = $this->t('Enter your e-mail address');
        $form['nom'] = [
            '#type' => 'textfield',
            '#title' => $this->t('Your Name').' *',
            '#placeholder' => $this->t('Enter your name'),
            '#required' => TRUE
        ];
        $form['prenom'] = [
            '#type' => 'textfield',
            '#title' => $this->t('Your Firstname').' *',
            '#placeholder' => $this->t('Enter your firstname'),
            '#required' => TRUE
        ];
        $form['submit'] = [
            '#type' => 'button',
            '#value' => $this->t('Sign up'),
            '#ajax' => [
                'callback' => '::myAjaxResult',
            ],
        ];

        return $form;
    }

    public function validateForm(array &$form, FormStateInterface $form_state)
    {
        $lastName = $form_state->getValue('nom');
        if(is_null($lastName) || empty($lastName)) {
            $form_state->setError($form['nom'], $this->t('Lastname is required'));
        }

        $firstName = $form_state->getValue('prenom');
        if(is_null($firstName) || empty($firstName)) {
            $form_state->setError($form['prenom'], $this->t('Firstname is required'));
        }
    }

    public function submitForm(array &$form, FormStateInterface $form_state)
    {
        //do nothing because it's an ajax form
    }

    /**
     * @param FormStateInterface $form_state
     * @return array|null
     */
    protected function formatReceivedData(FormStateInterface $form_state): ?array
    {
        $return = parent::formatReceivedData($form_state);

        $return['nom'] = $form_state->getValue('nom');
        $return['prenom'] = $form_state->getValue('prenom');

        return $return;
    }

    protected function initProfile()
    {
        return new SitramProfile();
    }

    public function myAjaxResult(array &$form, FormStateInterface $form_state)
    {
        $response = new AjaxResponse();

        $errors = $form_state->getErrors();
        if (empty($errors)) { //success form content
            $txtReturn = $this->submitProcess($form_state);

            $response->addCommand(new InvokeCommand('.js-hidden-part', 'removeClass', ['show']));
            $response->addCommand(new InvokeCommand('.result-message', 'addClass', ['success']));
        } else {
            $txtReturn = implode($errors, ', ');
        }

        $response->addCommand(
            new HtmlCommand('.result-message', $txtReturn)
        );

        $response->addCommand(new InvokeCommand(NULL, 'myCustomReloadReCatpcha'));

        return $response;
    }
}