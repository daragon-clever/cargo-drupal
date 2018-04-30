<?php
/**
 *  * @file
 *  * Contains \Drupal\recherchePdf\Form\recherchePdfForm.
 *  */

namespace Drupal\recherchePdf\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Messenger\MessengerInterface;

class RechercheForm extends FormBase
{
    /**
     * {@inheritdoc}
     */
    public function getFormId()
    {
        return 'recherchePdf_form';
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(array $form, FormStateInterface $form_state)
    {

        $form['ref-produit'] = array(
            '#type' => 'textfield',
            '#title' => t('Réference du produit:'),
            '#required' => TRUE,
        );

        $form['lot-produit'] = array(
            '#type' => 'textfield',
            '#title' => t('Lot du produit:'),
            '#required' => TRUE,
        );

        $form['actions']['#type'] = 'actions';
        $form['actions']['submit'] = array(
            '#type' => 'submit',
            '#value' => $this->t('Rechercher'),
            '#button_type' => 'primary',
        );

        $form['#theme'] = 'recherche';
        return $form;
    }

    /**
     * {@inheritdoc}
     */
    public function validateForm(array &$form, FormStateInterface $form_state)
    {
        //var_dump($form);

        if (strlen($form_state->getValue('candidate_number')) < 10) {
            $form_state->setErrorByName('candidate_number', $this->t('Mobile number is too short.'));
        }

    }

    /**
     * {@inheritdoc}
     */
    public function submitForm(array &$form, FormStateInterface $form_state)
    {

        // drupal_set_message($this->t('@can_name ,Your application is being submitted!', array('@can_name' => $form_state->getValue('candidate_name'))));

        drupal_set_message($form_state->getValue('ref-produit'));
        drupal_set_message($form_state->getValue('lot-produit'));
        /*
              foreach ($form_state->getValue() as $key => $value) {
                  // var_dump($value);
                  drupal_set_message($key . ': ' . $value);
              }*/
    }
}