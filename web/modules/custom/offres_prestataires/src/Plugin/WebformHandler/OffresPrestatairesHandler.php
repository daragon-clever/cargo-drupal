<?php

namespace Drupal\offres_prestataires\Plugin\WebformHandler;

use Drupal\Core\Form\FormStateInterface;
use Drupal\webform\Plugin\WebformHandlerBase;
use Drupal\webform\webformSubmissionInterface;
use Drupal\offres_prestataires\OffrePrestataireRepository;

/**
 * Form submission handler.
 *
 * @WebformHandler(
 *   id = "offres_prestataires",
 *   label = @Translation("Handler Offres prestataires"),
 *   category = @Translation("Form Handler"),
 *   description = @Translation("Handler nb_candidature module offres prestataires"),
 *   cardinality = \Drupal\webform\Plugin\WebformHandlerInterface::CARDINALITY_SINGLE,
 *   results = \Drupal\webform\Plugin\WebformHandlerInterface::RESULTS_PROCESSED,
 * )
 */
class OffresPrestatairesHandler extends WebformHandlerBase
{
    /**
     * {@inheritdoc}
     */
    public function defaultConfiguration() {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function confirmForm(array &$form, FormStateInterface $form_state, WebformSubmissionInterface $webform_submission)
    {
        $values = $webform_submission->getData();

        $offreRepository = \Drupal::service('offres_prestataires.repository');
        $offreRepository->updateNbCandidature($values['offre']);

        //todo : push candidature in scoptalent with api

        return true;
    }
}