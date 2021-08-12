<?php
namespace Drupal\newsletter\Plugin\Block;


use Drupal\Core\Block\BlockBase;
use Drupal\newsletter\Controller\NewsletterController;

/**
 * @Block(
 *   id = "inscription_block",
 *   admin_label = @Translation("Cargo - Inscription newsletter"),
 *   category = @Translation("Cargo - newsletter")
 * )
 */
class InscriptionBlock extends BlockBase
{
    /**
     * @var NewsletterController
     */
    protected $newsletterController;

    public function __construct(
        array $configuration,
        $plugin_id,
        $plugin_definition
    )
    {
        parent::__construct($configuration, $plugin_id, $plugin_definition);
        $this->newsletterController = new NewsletterController();
    }

    /**
     * Load template of form according to company
     *
     * {@inheritdoc}
     */
    public function build()
    {
        $myForm = $this->newsletterController->getCompanyForm();

        $array['#theme'] = "inscription";
        if (!is_null($myForm)) {
            $array['#form'] = $myForm;
        }

        return $array;
    }
}