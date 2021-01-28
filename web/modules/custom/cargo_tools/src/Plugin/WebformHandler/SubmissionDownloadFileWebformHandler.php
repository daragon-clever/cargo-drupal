<?php

namespace Drupal\cargo_tools\Plugin\WebformHandler;

use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\InvokeCommand;
use Drupal\Core\Form\FormStateInterface;
use Drupal\file\Entity\File;
use Drupal\webform\Plugin\WebformHandlerBase;
use Drupal\webform\WebformSubmissionInterface;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

/**
 * Form submission handler.
 *
 * @WebformHandler(
 *   id = "cargo_tools",
 *   label = @Translation("Submission Download File Webform Handler"),
 *   category = @Translation("Form Handler"),
 *   description = @Translation("Télécharge un fichier après la soumission"),
 *   cardinality = \Drupal\webform\Plugin\WebformHandlerInterface::CARDINALITY_SINGLE,
 *   results = \Drupal\webform\Plugin\WebformHandlerInterface::RESULTS_PROCESSED,
 * )
 */
class SubmissionDownloadFileWebformHandler extends WebformHandlerBase
{
    /**
     * {@inheritdoc}
     */
    public function defaultConfiguration() {
        return [
            'file_dl' => NULL,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function buildConfigurationForm(array $form, FormStateInterface $form_state)
    {
        $form['file'] = [
            '#type' => 'fieldset',
            '#title' => $this->t('File settings'),
            'file_dl' => [
                '#type' => 'managed_file',
                '#title' => t('File to download'),
                '#default_value' => $this->configuration['file_dl'],
                '#upload_location' => 'public://submission-dl-files/',
                '#upload_validators' => [
                    'file_validate_extensions' => ['pdf'],
                ],
                '#required' => TRUE
            ]
        ];

        return $this->setSettingsParents($form);
    }

    /**
     * {@inheritdoc}
     */
    public function submitConfigurationForm(array &$form, FormStateInterface $form_state) {
        parent::submitConfigurationForm($form, $form_state);

        $this->configuration['file_dl'] = $form_state->getValue('file_dl');

        if (isset($this->configuration['file_dl'][0])) {
            $fid = $this->configuration['file_dl'][0];
            $file = File::load($fid);

            $file->setPermanent();

            $file->save();

            $file_usage = \Drupal::service('file.usage');
            $file_usage->add($file, 'cargo_tools', 'cargo_tools', 1);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function confirmForm(array &$form, FormStateInterface $form_state, WebformSubmissionInterface $webform_submission)
    {
        $fileId = isset($this->configuration['file_dl'][0]) ? $this->configuration['file_dl'][0] : NULL;

        if ($fileId) {
            $fileToDl = File::load($fileId);
            $resp = $this->downloadFile($fileToDl->getFileUri(), $fileToDl->getFilename(), $form_state);
            $form_state->setResponse($resp);
        }
    }

    private function downloadFile($url, $filename, $form_state)
    {
        $response = new BinaryFileResponse($url);
        $response->setContentDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            $filename
        );
       return $response;
    }
}