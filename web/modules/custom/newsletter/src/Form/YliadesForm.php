<?php

namespace Drupal\newsletter\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\newsletter\Profile\YliadesProfile;

class YliadesForm extends AbstractForm
{
    public function getFormId()
    {
        return 'yliades-newsletter';
    }

    public function buildForm(array $form, FormStateInterface $form_state)
    {
        $form = parent::buildForm($form, $form_state);

        //Les marques
        $marques = [
            YliadesProfile::MARQUE_ALL => $this->t("All the brands"),
            YliadesProfile::MARQUE_SEMA_DESIGN => $this->t("Sema Design"),
            YliadesProfile::MARQUE_COMPTOIR_DE_FAMILLE => $this->t("Comptoir de Famille"),
            YliadesProfile::MARQUE_COTE_TABLE => $this->t('Côté Table'),
            YliadesProfile::MARQUE_GENEVIEVE_LETHU => $this->t("Geneviève Lethu"),
            YliadesProfile::MARQUE_JARDIN_D_ULYSSE => $this->t("Jardin d'Ulysse"),
            YliadesProfile::MARQUE_NATIVES => $this->t("Natives"),
        ];

        $form['email']['#placeholder'] = $this->t('Enter your e-mail address');
        $form['marques'] = [
            '#type' => 'checkboxes',
            '#options' => $marques
        ];
        $form['actions']['submit']['#value'] = $this->t("Send");

        return $form;
    }

    public function validateForm(array &$form, FormStateInterface $form_state)
    {
        parent::validateForm($form, $form_state);

        $brands = $form_state->getValue('marques');
        if (empty(array_filter($brands))) {
            $form_state->setErrorByName('marques', $this->t('Brands is required'));
        }
    }

    /**
     * @param FormStateInterface $form_state
     * @return array|null
     */
    protected function formatReceivedData(FormStateInterface $form_state): ?array
    {
        $return = parent::formatReceivedData($form_state);

        $return['brands'] = $this->formatAllBrands($form_state->getValue('marques'));

        return $return;
    }

    protected function initProfile()
    {
        return new YliadesProfile();
    }

    /**
     * Format brands array with key is brand and value is 0 or 1
     * Received ["a" => "a"] when "a" was checked and ["a" => 0] when "a" wasn't checked
     * Return ["a" => 1, "b" => 0, "c" => 0, "d" => 1] - return all brands field
     */
    private function formatAllBrands($brands)
    {
        $formatBrands = [];
        if (!empty($brands)) {
            foreach ($brands as $brand => $isCheck) {
                $formatBrands[$brand] = (is_string($isCheck) && !empty($isCheck)) ? 1 : 0;
            }

            if (isset($formatBrands[YliadesProfile::MARQUE_ALL])
                && $formatBrands[YliadesProfile::MARQUE_ALL] === 1) {
                $formatBrands = array_fill_keys(YliadesProfile::LES_MARQUES, 1);
            }
        }

        return $formatBrands;
    }
}