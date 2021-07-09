<?php

namespace Drupal\recherche_pdf\Plugin\Block;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Annotation\Translation;
use Drupal\Core\Block\Annotation\Block;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Block\BlockPluginInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\recherche_pdf\Config\Config;
use Drupal\recherche_pdf\Form\PdfSearchForm;

/**
 * @Block(
 *   id = "pdf_search_block",
 *   admin_label = @Translation("Cargo - Recherche PDF"),
 *   category = @Translation("Cargo - recherche_pdf")
 * )
 */
class PdfSearchBlock extends BlockBase implements BlockPluginInterface
{
    /**
     * {@inheritdoc}
     */
    public function build()
    {
        $buildArgs['#theme'] = "pdf-search--block";

        if ($this->isEntityExist()) {
            $pdfSearchForm = $this->initPdfSearchFormWithBlockConfig();
            $buildArgs['#form'] = $pdfSearchForm;
        } else {
            $buildArgs['#error'] = t("This search form are not configured yet. Please try again later.");
        }

        return $buildArgs;
    }

    /**
     * {@inheritdoc}
     */
    protected function blockAccess(AccountInterface $account)
    {
        return AccessResult::allowedIfHasPermission($account, 'access content');
    }

    /**
     * {@inheritdoc}
     */
    public function blockForm($form, FormStateInterface $form_state)
    {
        $form = parent::blockForm($form, $form_state);

        $config = $this->getConfiguration();
        $form['entity'] = [
            '#type' => 'select',
            '#title' => t('Trigramme société'),
            '#options' => $this->formatEntitySelectOptions(),
            '#default_value' => isset($config['entity']) ? $config['entity'] : '',
            '#required' => TRUE,
        ];
        $form['display_lot'] = [
            '#type' => 'checkbox',
            '#title' => t('Activer la recherche avec avec un n° de lot'),
            '#description' => t('(en plus du sku)'),
            '#default_value' => isset($config['display_lot']) ? $config['display_lot'] : 0,
        ];
        $form['lot_req'] = [
            '#type' => 'checkbox',
            '#title' => t('Lot obligatoire'),
            '#default_value' => isset($config['lot_req']) ? $config['lot_req'] : 0,
        ];
        $form['submit_redirect_list'] = [
            '#type' => 'checkbox',
            '#title' => t('Rediriger vers une liste'),
            '#default_value' => isset($config['submit_redirect_list']) ? $config['submit_redirect_list'] : 0,
        ];
        $form['custom_form_id'] = [
            '#type' => 'textfield',
            '#title' => t('Id du formulaire UNIQUE'),
            '#default_value' => isset($config['custom_form_id']) ? $config['custom_form_id'] : '',
            '#required' => TRUE,
        ];
        $form['sku_txt'] = [
            '#type' => 'textfield',
            '#title' => t('Texte pour le sku'),
            '#default_value' => isset($config['sku_txt']) ? $config['sku_txt'] : '',
            '#description' => t('Valeur par défaut "Sku". Si site multilangue : mettre en anglais et traduire en franças dans les traductions du site.'),
        ];
        $form['lot_txt'] = [
            '#type' => 'textfield',
            '#title' => t('Texte pour le n° de lot'),
            '#default_value' => isset($config['lot_txt']) ? $config['lot_txt'] : '',
            '#description' => t('Valeur par défaut "Lot". Si site multilangue : mettre en anglais et traduire en franças dans les traductions du site.'),
        ];
        $form['submit_txt'] = [
            '#type' => 'textfield',
            '#title' => t('Texte pour le bouton du formulaire'),
            '#default_value' => isset($config['submit_txt']) ? $config['submit_txt'] : '',
            '#description' => t('Valeur par défaut "Télécharger". Si site multilangue : mettre en anglais et traduire en franças dans les traductions du site.'),
        ];

        return $form;
    }

    /**
     * {@inheritdoc}
     */
    public function blockSubmit($form, FormStateInterface $form_state)
    {
        parent::blockSubmit($form, $form_state);

        $this->configuration['entity'] = $form_state->getValue('entity');
        $this->configuration['display_lot'] = $form_state->getValue('display_lot');
        $this->configuration['lot_req'] = $form_state->getValue('lot_req');
        $this->configuration['submit_redirect_list'] = $form_state->getValue('submit_redirect_list');
        $this->configuration['custom_form_id'] = $form_state->getValue('custom_form_id');
        $this->configuration['sku_txt'] = $form_state->getValue('sku_txt');
        $this->configuration['lot_txt'] = $form_state->getValue('lot_txt');
        $this->configuration['submit_txt'] = $form_state->getValue('submit_txt');
    }

    /**
     * {@inheritdoc}
     */
    public function getCacheMaxAge()
    {
        return 0;
    }

    private function formatEntitySelectOptions()
    {
        $return = [];
        $entityArr = array_keys(Config::qrcodeConfig());
        foreach ($entityArr as $val) {
            $return[$val] = $val;
        }
        return $return;
    }

    private function isEntityExist()
    {
        return (
            isset($this->configuration['entity'])
            && !is_null(Config::getQrcodeConfig($this->configuration['entity']))
        );
    }

    private function initPdfSearchFormWithBlockConfig()
    {
        $pdfSearchForm = new PdfSearchForm();

        $pdfSearchForm->setEntityKey($this->configuration['entity']);

        if (isset($this->configuration['custom_form_id']) && !empty($this->configuration['custom_form_id'])) {
            $pdfSearchForm->setFormId($this->configuration['custom_form_id']);
        }
        if (isset($this->configuration['display_lot']) && $this->configuration['display_lot'] === 1) {
            $pdfSearchForm->setLotInputDisplay(true);
        }
        if (isset($this->configuration['lot_req']) && $this->configuration['lot_req'] === 1) {
            $pdfSearchForm->setLotInputReq(true);
        }
        if (isset($this->configuration['submit_redirect_list']) && $this->configuration['submit_redirect_list'] === 1) {
            $pdfSearchForm->setRedirectListingPage(true);
        }

        $pdfSearchForm = \Drupal::formBuilder()->getForm($pdfSearchForm, $this->configuration);

        return $pdfSearchForm;
    }
}