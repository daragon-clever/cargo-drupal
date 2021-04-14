<?php

namespace Drupal\offres_prestataires\Plugin\WebformHandler;

use Drupal\file\Entity\File;
use Drupal\offres_prestataires\Helper\Request;
use Drupal\Core\Form\FormStateInterface;
use Drupal\webform\Plugin\WebformHandlerBase;
use Drupal\webform\webformSubmissionInterface;
//use Drupal\offres_prestataires\OffrePrestataireRepository;

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
     * @var Request
     */
    private $requestHelper;

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
        $this->requestHelper = new Request();

        $values = $webform_submission->getData();

        $offreRepository = \Drupal::service('offres_prestataires.repository');
        $offreRepository->updateNbCandidature($values['offre']);

        //push documents
        $mlFile = $this->getPathFile($values['lm']);
        $mlToken = $this->requestHelper->postDocument($mlFile); //todo: add filename or path if it's possible
        $cvFile = $this->getPathFile($values['cv']);
        $cvToken = $this->requestHelper->postDocument($cvFile); //todo: add filename or path if it's possible

        //push profile
        $profileData = $this->formatProfileData($values);
        if (!empty($profileData)) {
            $dataForReq['cvToken'] = $cvToken;
            $dataForReq['mlToken'] = $mlToken;
            $dataForReq['profile'] = $profileData;
            $dataForReq['vacancyId'] = $values['ref'];
            $this->requestHelper->vacancyApply($dataForReq);
        }

        return true;
    }

    private function formatProfileData($formData)
    {
        $arrForm = ["nom", "prenom", "code_postal", "ville",
            "email"/*, "telephone", "situation_actuelle", "contrat_recherche", "activite_profil",
            "niveau_experience", "metier_interesse", "source"*/];
        $arrAPI = ["lastname", "firstname", "addressZipCode", "addressCity",
            "email"/*, "mobilePhone", "employmentStatusCode", "desiredContractTypes", "desiredBusinessDomains",
            "","desiredBusinessDomains", ""*/];

        $arrLink = array_combine($arrForm, $arrAPI);

        $profileData = [];
        foreach ($arrLink as $keyForm => $keyAPI) {
            if (isset($formData[$keyForm])) {
//                if (in_array($keyForm, ["missionDescription", "businessDescription", "profileDescription"])) {
//                    $profileData[$keyAPI] = $this->cleanDescription($formData[$keyForm]);
//                } elseif (in_array($keyForm, ["contractTypeNames", "businessDomains"])) {
//                    $profileData[$keyAPI] = $this->convertArray($formData[$keyForm]);
//                } else {
                    $profileData[$keyAPI] = $formData[$keyForm];
//                }
            }
        }

        //todo: telephone => mobilePhone || homePhone

        return $profileData;
    }

    private function getPathFile($fileId)
    {
        return File::load($fileId)->getFileUri();
    }
}