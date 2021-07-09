<?php

namespace Drupal\recherche_pdf\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class Settings extends ConfigFormBase
{

    /**
     * {@inheritdoc}
     */
    public function getFormId()
    {
        return 'recherche_pdf_settings';
    }

    /**
     * {@inheritdoc}
     */
    protected function getEditableConfigNames()
    {
        return [
            'recherche_pdf.settings',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(array $form, FormStateInterface $form_state)
    {
        $config = $this->config('recherche_pdf.settings');

        $form['recherche_pdf_prod_mode'] = [
            '#type' => 'checkbox',
            '#title' => t('Mode production de l\'API admin.url-qrcodes'),
            '#description' => t('Pour éviter d\'incrémenter le nombre de vue des fichiers téléchargés'),
            '#default_value' => $config->get('api.prod_mode'),
        ];

        return parent::buildForm($form, $form_state);
    }

    /**
     * {@inheritdoc}
     */
    public function submitForm(array &$form, FormStateInterface $form_state) {
        // Retrieve the configuration
        $this->configFactory->getEditable('recherche_pdf.settings')
            // Set the submitted configuration setting
            ->set('api.prod_mode', $form_state->getValue('recherche_pdf_prod_mode'))
            ->save();

        parent::submitForm($form, $form_state);
    }
}