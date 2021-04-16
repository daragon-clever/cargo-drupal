<?php
declare(strict_types=1);

namespace Drupal\offres_emploi\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\offres_emploi\Helper\OffreEmploiHelperTrait;
use Drupal\offres_emploi\OffreEmploiRepository;
use Symfony\Component\DependencyInjection\ContainerInterface;

class OffresEmploiActionController extends ControllerBase
{
    /**
     * @var OffreEmploiRepository
     */
    private $offreRepository;


    use OffreEmploiHelperTrait;

    /**
     * {@inheritdoc}
     */
    public static function create(ContainerInterface $container) {
        return new static($container->get('offres_emploi.repository'));
    }

    public function __construct(OffreEmploiRepository $offreRepository)
    {
        $this->offreRepository = $offreRepository;
    }


    public function apply($ref)
    {
        if (isset($ref)) {
            $webform = \Drupal::entityTypeManager()->getStorage('webform')->load('postuler_annonce');

            $dataPoste = $this->offreRepository->findBy(['codeRecrutement' => $ref, 'active' => 1]);

            return [
                '#theme' => 'offres_emploi--form-postuler',
                '#offerName' => $dataPoste[0]->intitulePoste,
                '#offerRef' => $ref,
                "#form" => $webform->getSubmissionForm()
            ];
        }
    }
}