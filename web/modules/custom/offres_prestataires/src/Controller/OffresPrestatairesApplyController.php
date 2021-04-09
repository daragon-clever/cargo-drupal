<?php
declare(strict_types=1);

namespace Drupal\offres_prestataires\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\offres_prestataires\OffrePrestataireRepository;
use Symfony\Component\DependencyInjection\ContainerInterface;

class OffresPrestatairesApplyController extends ControllerBase
{
    /**
     * @var OffrePrestataireRepository
     */
    private $offreRepository;

    /**
     * {@inheritdoc}
     */
    public static function create(ContainerInterface $container) {
        return new static($container->get('offres_prestataires.repository'));
    }

    public function __construct(OffrePrestataireRepository $offreRepository)
    {
        $this->offreRepository = $offreRepository;
    }

    public function apply($ref)
    {
        if (isset($ref)) {
            $webform = \Drupal::entityTypeManager()->getStorage('webform')->load('candidature_offre_prestataire');

            $dataPoste = $this->offreRepository->findBy(['id_scoptalent' => $ref, 'active' => 1]);

            return [
                '#theme' => 'offres_prestataires--apply-form',
                '#offerName' => $dataPoste[0]->title,
                '#offerRef' => $ref,
                "#form" => $webform->getSubmissionForm()
            ];
        }
    }
}