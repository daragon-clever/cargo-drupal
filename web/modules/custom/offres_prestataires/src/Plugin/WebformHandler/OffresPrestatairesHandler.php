<?php

namespace Drupal\offres_prestataires\Plugin\WebformHandler;

use Drupal\file\Entity\File;
use Drupal\offres_prestataires\Helper\Request;
use Drupal\Core\Form\FormStateInterface;
use Drupal\webform\Plugin\WebformHandlerBase;
use Drupal\webform\webformSubmissionInterface;

/**
 * Form submission handler.
 *
 * @WebformHandler(
 *   id = "offres_prestataires",
 *   label = @Translation("Handler Offres prestataires"),
 *   category = @Translation("Form Handler"),
 *   description = @Translation("Handler module offres prestataires"),
 *   cardinality = \Drupal\webform\Plugin\WebformHandlerInterface::CARDINALITY_SINGLE,
 *   results = \Drupal\webform\Plugin\WebformHandlerInterface::RESULTS_PROCESSED,
 * )
 */
class OffresPrestatairesHandler extends WebformHandlerBase
{
    const OFFRE_REF_FORM_KEY = "offre";

    const ID_SOURCE_NON_RENSEIGNEE = 11;

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

        $isOffer = $this->isOffer($values);

        if ($isOffer) {
            $offreRepository = \Drupal::service('offres_prestataires.repository');
            $offreRepository->updateNbCandidature($values[self::OFFRE_REF_FORM_KEY]);
        }

        //push documents
        $mlToken = $this->createDocumentToken($values, 'lettre_de_motivation');
        $cvToken = $this->createDocumentToken($values, 'cv');

        //push profile
        $profileData = $this->formatProfileData($values);
        if (!empty($profileData)) {
            if (!is_null($cvToken) && isset($cvToken['token'])) $dataForReq['cvToken'] = $cvToken['token'];
            if (!is_null($mlToken) && isset($mlToken['token'])) $dataForReq['mlToken'] = $mlToken['token'];
            if ($isOffer) $dataForReq['vacancyId'] = $values[self::OFFRE_REF_FORM_KEY];
            $dataForReq['originId'] = !empty($values['candidat_source']) ? (int) ($values['candidat_source']) : self::ID_SOURCE_NON_RENSEIGNEE;
            $dataForReq['profile'] = $profileData;

            $this->requestHelper->vacancyApply($dataForReq);
        }

        return true;
    }

    /**
     * @param $values
     * @return bool
     */
    private function isOffer($values)
    {
        return (isset($values[self::OFFRE_REF_FORM_KEY]) && !empty($values[self::OFFRE_REF_FORM_KEY]));
    }

    /**
     * @param $values
     * @param $keyValue
     * @return array|null
     */
    private function createDocumentToken($values, $keyValue)
    {
        if (isset($values[$keyValue]) && !empty($values[$keyValue])) {
            $file = $this->getPathFile($values[$keyValue]);
            $token = $this->requestHelper->postDocument($file);
            return $token;
        }
    }

    /**
     * @param $formData
     * @return array
     */
    private function formatProfileData($formData)
    {
        $arrForm = ["nom", "prenom", "code_postal", "ville",
            "email", "telephone", "current_situation", "search_contract_type", "principal_activities",
            "niveau_experience", "search_job_types"];
        $arrAPI = ["lastname", "firstname", "addressZipCode", "addressCity",
            "email", "mobilePhone", "employmentStatusCode", "desiredContractTypes", "desiredBusinessDomains",
            "yearExperienceCount","desiredCompanyTypes"];

        $arrLink = array_combine($arrForm, $arrAPI);

        $profileData = [];
        foreach ($arrLink as $keyForm => $keyAPI) {
            if (isset($formData[$keyForm])) {
                if ($keyForm == "telephone" && !in_array(substr($formData[$keyForm], 0, 2), ["06", "07"])) { //phone
                    $profileData['homePhone'] = $formData[$keyForm];
                } else if (in_array($keyForm, ['current_situation', 'search_contract_type', 'principal_activities', 'search_job_types'])) { //taxonomy
                    if (in_array($keyForm, ['search_contract_type', 'principal_activities', 'search_job_types'])) { //multiple values
                        foreach ($formData[$keyForm] as $val) {
                            $profileData[$keyAPI][] = (int) $val;
                        }
                    } else {
                        $profileData[$keyAPI] = (int) $formData[$keyForm];
                    }
                } else if ($keyForm == "niveau_experience") { //int
                    $profileData[$keyAPI] = (int) $formData[$keyForm];
                } else {
                    $profileData[$keyAPI] = $formData[$keyForm];
                }
            }
        }

        return $profileData;
    }

    private function getPathFile($fileId)
    {
        return File::load($fileId)->getFileUri();
    }
}