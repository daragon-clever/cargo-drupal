<?php

namespace Drupal\newsletter\Form\Company;


use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\newsletter\Controller\Company\YliadesController;

class YliadesForm extends FormBase
{

    /**
     * {@inheritdoc}
     */
    public function getFormId()
    {
        return 'yliades-newsletter';
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(array $form, FormStateInterface $form_state)
    {
        //Les marques
        $marques = [
            YliadesController::MARQUE_ALL => $this->t("All the brands"),
            YliadesController::MARQUE_SEMA_DESIGN => $this->t("Sema Design"),
            YliadesController::MARQUE_COMPTOIR_DE_FAMILLE => $this->t("Comptoir de Famille"),
            YliadesController::MARQUE_COTE_TABLE => $this->t('Côté Table'),
            YliadesController::MARQUE_GENEVIEVE_LETHU => $this->t("Geneviève Lethu"),
            YliadesController::MARQUE_JARDIN_D_ULYSSE => $this->t("Jardin d'Ulysse"),
        ];

        //My Form
        $form = [
            'marques' => [
                '#type' => 'checkboxes',
                '#options' => $marques
            ],
            'mail' => [
                '#type' => 'email',
                '#placeholder' => $this->t("Enter your e-mail address"),
                '#required' => TRUE
            ],
            'captcha' => [
                '#type' => 'captcha',
                '#captcha_type' => 'recaptcha/reCAPTCHA'
            ],
            'actions' => [
                '#type' => 'actions',
                'submit' => [
                    '#type' => 'submit',
                    '#value' => $this->t('Send')
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
            $form_state->setError($form['mail'], $this->t('Email is required'));
        } elseif (!\Drupal::service('email.validator')->isValid($mail)) {
            $form_state->setError($form['mail'], $this->t('Email is malformed'));
        }

        $brands = $brands = $form_state->getValue('marques');
        if (empty(array_filter($brands))) {
            $form_state->setErrorByName('marques', $this->t('Brands is required'));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function submitForm(array &$form, FormStateInterface $form_state)
    {
        $email = $form_state->getValue('mail');
        $brands = $form_state->getValue('marques');
        $formatBrands = $this->formatAllBrands($brands);

        //data for database and actito
        $data = [
            'email' => $email,
            'brands' => $formatBrands,
            'active' => 1,
            'exported' => 0
        ];

        //Call controller of Yliades to execute action
        $controllerBase = new YliadesController();
        $returnMsg = $controllerBase->doAction($data);

        \Drupal::messenger()->addMessage($returnMsg['msg'], $returnMsg['type']);
    }

    /**
     * Format brands array with key is brand and value is 0 or 1
     */
    private function formatAllBrands($brands)
    {
        $formatBrands = $this->setValueAllBrands(0);//get array with all brands (value -> 0)
        foreach ($brands as $key => $value) {
            if (is_string($value)) {
                if ($value == YliadesController::MARQUE_ALL && $key == YliadesController::MARQUE_ALL) {
                    $formatBrands = $this->setValueAllBrands(1);
                    break;
                } else {
                    $formatBrands[$value] = 1;
                }
            }
        }

        $marques = $this->setValueAllBrands(0);//get array with all brands (value -> 0)
        foreach ($brands as $key => $value) {
            if (is_string($value)) {
                if ($value == YliadesController::MARQUE_ALL && $key == YliadesController::MARQUE_ALL) {
                    $marques = $this->setValueAllBrands(1);
                    break;
                } else {
                    $marques[$value] = 1;
                }
            }
        }
        $data['brands'] = $marques;

        $base = new YliadesController();
        $return = $base->doAction($data);
        //$base->savePeopleInActito($data);//à activer à mon retour une fois les tests refait et fonctionnels

        \Drupal::messenger()->addMessage($return['msg'], $return['type']);
    }

    private function setValueAllBrands(int $val): array
    {
        $newArray = array_fill_keys(YliadesController::LES_MARQUES, $val);
        return $newArray;
    }

}