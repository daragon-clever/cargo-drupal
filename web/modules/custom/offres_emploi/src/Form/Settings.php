<?php

namespace Drupal\offres_emploi\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class Settings extends ConfigFormBase
{
    /**
     * {@inheritdoc}
     */
    public function getFormId()
    {
        return 'offres_emploi_settings';
    }

    /**
     * {@inheritdoc}
     */
    protected function getEditableConfigNames()
    {
        return [
            'offres_emploi.settings',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(array $form, FormStateInterface $form_state)
    {
        $config = $this->config('offres_emploi.settings');

        $form['offres_emploi_url'] = array(
            '#type' => 'textfield',
            '#title' => $this->t('Url de base'),
            '#default_value' => $config->get('routing.base'),
        );

        $form['offres_emploi_sirh'] = array(
            '#type' => 'textfield',
            '#title' => $this->t('Url SIRH'),
            '#default_value' => $config->get('sirh.url'),
        );

        return parent::buildForm($form, $form_state);
    }

    /**
     * {@inheritdoc}
     */
    public function submitForm(array &$form, FormStateInterface $form_state) {
        // Retrieve the configuration
        $this->configFactory->getEditable('offres_emploi.settings')
            // Set the submitted configuration setting
            ->set('routing.base', $form_state->getValue('offres_emploi_url'))
            ->set('sirh.url', $form_state->getValue('offres_emploi_sirh'))
            ->save();

        parent::submitForm($form, $form_state);
    }
}