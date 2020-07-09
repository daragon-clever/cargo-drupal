<?php
namespace Drupal\offres_emploi\Plugin\WebformHandler;

use Drupal\Core\Form\FormStateInterface;
use Drupal\webform\Plugin\WebformHandlerBase;
use Drupal\webform\webformSubmissionInterface;
use Drupal\offres_emploi\OffreEmploiRepository;


/**
 * Form submission handler.
 *
 * @WebformHandler(
 *   id = "offres_emploi",
 *   label = @Translation("Handler Offres emploi"),
 *   category = @Translation("Form Handler"),
 *   description = @Translation("Handler nbCandidature module offres emploi"),
 *   cardinality = \Drupal\webform\Plugin\WebformHandlerInterface::CARDINALITY_SINGLE,
 *   results = \Drupal\webform\Plugin\WebformHandlerInterface::RESULTS_PROCESSED,
 * )
 */
class OffresEmploiHandler extends WebformHandlerBase
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

        $connection = \Drupal::service('database');
        $offreRepository = new OffreEmploiRepository($connection);

        $offreRepository->updateNbCandidature($values['offre']);

        return true;
    }
}