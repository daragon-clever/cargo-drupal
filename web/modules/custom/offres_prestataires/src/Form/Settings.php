<?php

namespace Drupal\offres_prestataires\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class Settings extends ConfigFormBase
{
    /**
     * {@inheritdoc}
     */
    public function getFormId()
    {
        return 'offres_prestataires_settings';
    }

    /**
     * {@inheritdoc}
     */
    protected function getEditableConfigNames()
    {
        return [
            'offres_prestataires.settings',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(array $form, FormStateInterface $form_state)
    {
        $config = $this->config('offres_prestataires.settings');

        $form['offres_prestataires_apikey'] = array(
            '#type' => 'textfield',
            '#title' => $this->t('Clé API'),
            '#default_value' => $config->get('api.key'),
        );
        $form['offres_prestataires_spontaneous_offer_id'] = array(
            '#type' => 'textfield',
            '#title' => $this->t('ID de l\'offre spontanée'),
            '#default_value' => $config->get('spontaneousOffer.id'),
        );

        return parent::buildForm($form, $form_state);
    }

    /**
     * {@inheritdoc}
     */
    public function submitForm(array &$form, FormStateInterface $form_state) {
        // Retrieve the configuration
        $this->configFactory->getEditable('offres_prestataires.settings')
            // Set the submitted configuration setting
            ->set('api.key', $form_state->getValue('offres_prestataires_apikey'))
            ->set('spontaneousOffer.id', $form_state->getValue('offres_prestataires_spontaneous_offer_id'))
            ->save();

        parent::submitForm($form, $form_state);
    }
}