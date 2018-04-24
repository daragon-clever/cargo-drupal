<?php
/**
 * Created by PhpStorm.
 * User: nit
 * Date: 20/04/2018
 * Time: 14:35
 */
namespace Drupal\hello_world\Controller;
use Drupal\Core\Controller\ControllerBase;

class HelloController extends ControllerBase {

    /**
     * Méthode appelée dans le routing via l'instruction :
     * _controller: '\Drupal\hello_world\Controller\HelloController::world' \Drupal\hello_world\Controller\HelloController::world
     * @return  array  tableau de rendu spécifiant le contenu de la page
     */
    public function world() {
        return array(
            '#theme' => 'world',
            '#texte' => $this->t('Hello world !'),
        );

    }

}