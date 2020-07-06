<?php
namespace Drupal\offres_emploi\Plugin\WebformHandler;

use Drupal\Core\Form\FormStateInterface;
use Drupal\webform\Plugin\WebformHandlerBase;
use Drupal\webform\webformSubmissionInterface;
use Drupal\Core\Url;


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
class OffresEmploiHandler extends WebformHandlerBase {

    /**
     * {@inheritdoc}
     */
    public function defaultConfiguration() {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function confirmForm(array &$form, FormStateInterface $form_state, WebformSubmissionInterface $webform_submission) {
        $values = $webform_submission->getData();

        $conn = \Drupal::database();
        $conn->update("offres_emploi")
            ->expression('nbCandidature', 'nbCandidature + 1')
            ->condition('codeRecrutement', $values['offre'], '=')
            ->execute();

        return true;
    }
}