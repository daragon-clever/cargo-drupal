<?php
namespace Drupal\newsletterMarques\Form;

use \Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use \Drupal\Core\Form\drupal_set_message;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\HtmlCommand;

use Drupal\newsletterMarques\Controller\NewsletterController;
use ReCaptcha\ReCaptcha;
use ReCaptcha\RequestMethod;

class CustomForm extends FormBase {
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
        return 'customformid';
    }

    /**
     * Form constructor.
     *
     * @param array $form
     *   An associative array containing the structure of the form.
     * @param \Drupal\Core\Form\FormStateInterface $form_state
     *   The current state of the form.
     *
     * @return array
     *   The form structure.
     */
    public function buildForm(array $form, FormStateInterface $form_state)
    {
        //Les marques
        $marques = [
            'toutes_les_marques' => $this->t("Toutes les marques"),
            'sema_design' => $this->t("Sema Design"),
            'comptoir_de_famille' => $this->t("Comptoir de Famille"),
            'cote_table' => $this->t('Côté Table'),
            'genevieve_lethu' => $this->t("Geneviève Lethu"),
            'jardin_d_ulysse' => $this->t("Jardin d'Ulysse"),
        ];

        //My Form
        $form['message'] = [
            '#type' => 'markup',
            '#markup' => '<div class="result_message"></div>'
        ];

        $form['marques'] = [
            '#type' => 'checkboxes',
            '#options' => $marques
        ];

        $form['mail'] = [
            '#type' => 'email',
            '#placeholder' => 'Saisissez votre adresse email',
            '#required' => TRUE
        ];

        $form['captcha'] = array (
            '#type' => 'captcha',
            '#captcha_type' => 'recaptcha/reCAPTCHA'
        );

        $form['actions'] = [
            '#type' => 'button',
            '#value' => $this->t('Envoyer'),
            '#ajax' => [
                'callback' => '::setMessage'
            ]
        ];

        return $form;
    }

    public function setMessage(array $form, FormStateInterface $form_state)
    {
        //Initialize variables
        $email = $form_state->getValue('mail');
        $choixMarques = $form_state->getValue('marques');
        $response_recaptcha = $_POST['g-recaptcha-response'];


        if ($email && $choixMarques) {
            if (isset($response_recaptcha) && !empty($response_recaptcha)) {
                //your site secret key
                $secret = '6Lf-g24UAAAAAIiMGEfFQl4UWEPcoZbh2DQz4CUh';
                //get verify response data
                $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secret . '&response=' . $response_recaptcha);
                $responseData = json_decode($verifyResponse);
//            var_dump($responseData);
                if ($responseData->success) {
                    $newsletter = new NewsletterController();
                    $return = $newsletter->doAction($choixMarques, $email);
                    if ($return == 'insert') {
                        $msg = "Vous venez de vous inscrire à la newsletter";
                    } else if ($return == 'update') {
                        $msg = "Vous venez de mettre à jour vos préférences newsletter pour l'adresse : " . $email;
                    } else {
                        $msg = "Erreur";
                    }
                } else {
                    $msg = 'Veuillez réessayer';
                }
            } else {
                $msg = 'Veuillez cocher la case "Je ne suis pas un robot"';
            }
        } else {
            $msg = "Veuillez remplir les champs";
        }

        //Ajax Request
        $response = new AjaxResponse();
        $response->addCommand(
            new HtmlCommand(
                '.result_message',
                $msg
            )
        );
        return $response;
    }

    /**
     * Form submission handler.
     *
     * @param array $form
     *   An associative array containing the structure of the form.
     * @param \Drupal\Core\Form\FormStateInterface $form_state
     *   The current state of the form.
     */
    public function submitForm(array &$form, FormStateInterface $form_state)
    {
        drupal_set_message($form_state->getValue('number_1') + $form_state->getValue('number_2'));
    }
}