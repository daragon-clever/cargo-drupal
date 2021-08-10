<?php

namespace Drupal\recherche_pdf\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;

class PdfSearchForm extends FormBase
{
    /**
     * @var string
     */
    private $formId = "pdf-search-form";

    /**
     * @var string
     */
    private $entityKey;

    /**
     * @var bool
     */
    private $lotInputDisplay = false;

    /**
     * @var bool
     */
    private $lotInputReq = false;

    /**
     * @var bool
     */
    private $redirectListingPage = false;

    /**
     * @param $formId
     */
    public function setFormId($formId)
    {
        $this->formId = $formId;
    }

    /**
     * @param $entityKey
     */
    public function setEntityKey($entityKey)
    {
        $this->entityKey = $entityKey;
    }

    /**
     * @param $lotInputDisplay
     */
    public function setLotInputDisplay($lotInputDisplay)
    {
        $this->lotInputDisplay = $lotInputDisplay;
    }

    /**
     * @param $lotInputReq
     */
    public function setLotInputReq($lotInputReq)
    {
        $this->lotInputReq = $lotInputReq;
    }

    /**
     * @param $redirectListingPage
     */
    public function setRedirectListingPage($redirectListingPage)
    {
        $this->redirectListingPage = $redirectListingPage;
    }

    /**
     * Returns a unique string identifying the form.
     *
     * The returned ID should be a unique string that can be a valid PHP function
     * name, since it's used in hook implementation names such as
     * hook_form_FORM_ID_alter().
     *
     * @return string
     *   The unique string identifying the form.
     */
    public function getFormId()
    {
        return $this->formId;
    }

    /**
     * Form constructor.
     *
     * @param array $form
     *   An associative array containing the structure of the form.
     * @param \Drupal\Core\Form\FormStateInterface $form_state
     *   The current state of the form.
     * @param $args
     *
     * @return array
     *   The form structure.
     */
    public function buildForm(array $form, FormStateInterface $form_state, $args = NULL)
    {
        //change form action url
        if ($this->redirectListingPage) {
            $form['#action'] = Url::fromRoute('recherche_pdf.list')->toString();
        } else {
            $form['#action'] = Url::fromRoute('recherche_pdf.dl')->toString();
        }

        $form['sku'] = [
            '#type' => 'textfield',
            '#title' => t(isset($args['sku_txt']) && !empty($args['sku_txt']) ? $args['sku_txt'] : 'Sku'),
            '#placeholder' => t(isset($args['sku_placeholder']) && !empty($args['sku_placeholder']) ? $args['sku_placeholder'] : 'Sku'),
            '#required' => TRUE,
        ];

        if ($this->lotInputDisplay) {
            $form['lot'] = [
                '#type' => 'textfield',
                '#title' => t(isset($args['lot_txt']) && !empty($args['lot_txt']) ? $args['lot_txt'] : 'Lot'),
                '#placeholder' => t(isset($args['lot_placeholder']) && !empty($args['lot_placeholder']) ? $args['lot_placeholder'] : 'Lot'),
                '#required' => $this->lotInputReq,
            ];
        }

        $form['entity'] = [
            '#type' => 'hidden',
            '#value' => $this->entityKey,
        ];

        $form['actions'] = [
            '#type' => 'actions',
            'submit' => [
                '#type' => 'submit',
                '#value' => t(isset($args['submit_txt']) && !empty($args['submit_txt']) ? $args['submit_txt'] : 'Download'),
            ]
        ];

        return $form;
    }

    /**
     * @param array $form
     * @param FormStateInterface $form_state
     */
    public function submitForm(array &$form, FormStateInterface $form_state)
    {
        parent::submitForm($form, $form_state);
    }
}