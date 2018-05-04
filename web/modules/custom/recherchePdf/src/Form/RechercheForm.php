<?php

/* Fichier non utilisé pour le moment - 04/05/2018 - Nico */

/**
 *  * @file
 *  * Contains \Drupal\recherchePdf\Form\recherchePdfForm.
 *  */

namespace Drupal\recherchePdf\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Connection;
use Drupal\Core\Url;

class RechercheForm extends FormBase
{
    protected $messenger;

    public function __construct()
    {
        $this->messenger = \Drupal::messenger();
    }

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
        $form['ref_produit'] = array(
            '#type' => 'textfield',
            '#title' => t('Réference du produit:'),
            '#required' => TRUE,
        );

        $form['lot_produit'] = array(
            '#type' => 'textfield',
            '#title' => t('Lot du produit:'),
        );

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
        if (strlen($form_state->getValue('ref_produit')) == 0 && strlen($form_state->getValue('lot_produit')) == 0) {
            $form_state->setErrorByName('ref_produit', $this->t('Entrer la référence du produit ou bien le lot du produit.'));
        }

    }

    /**
     * {@inheritdoc}
     */
    public function submitForm(array &$form, FormStateInterface $form_state)
    {

        $refProduit = $form_state->getValue('ref_produit');
        $lotProduit = $form_state->getValue('lot_produit');

        $pdf = $this->getByRefOrLot($refProduit, $lotProduit);
        $rslt = $pdf[0]->name_fic;

        if (!($rslt)) {
            $this->messenger->addMessage("Fiche de données sécurité non trouvée merci de vérifier votre saisie");
            $url = Url::fromRoute('recherchePdf.form');
            $internal_link = \Drupal::l(t(' Retour'), $url);

            echo "Fiche de données sécurité non trouvée merci de vérifier votre saisie. ";
            echo $internal_link->getGeneratedLink();
            die();
        } else {
            $form_state->setRedirect('resultSearch.form', [], ['query' => [
                'fiche_pdf' => $rslt,
            ]]);
        }
    }

    public function getByRefOrLot($refProduit = NULL, $lotProduit = FALSE)
    {
        // Switch to external database
        \Drupal\Core\Database\Database::setActiveConnection('QRcodeTBC');

        // Get a connection going
        $db = \Drupal\Core\Database\Database::getConnection();

        // $connection = \Drupal::database();

        if ($refProduit && strlen($lotProduit == 0)) {

            $query = $db->query("SELECT name_fic FROM fiches_produit WHERE RefProduit ='" . $refProduit . "'");
        } elseif ($lotProduit && strlen($refProduit == 0)) {
            $query = $db->query("SELECT name_fic FROM fiches_produit WHERE LotProduit ='" . $lotProduit . "'");
        } else {
            $query = $db->query("SELECT name_fic FROM fiches_produit WHERE LotProduit = '" . $lotProduit . "'AND  RefProduit = '" . $refProduit . "'");
        }
        $result = $query->fetchAll();

        // Switch back
        \Drupal\Core\Database\Database::setActiveConnection();
        return $result;
    }
}