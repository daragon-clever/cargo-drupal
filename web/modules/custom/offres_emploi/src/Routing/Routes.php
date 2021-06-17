<?php

namespace Drupal\offres_emploi\Routing;

use Drupal\offres_emploi\Config\Config;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

class Routes
{
    const DEFAULT_BASE_URL = 'offres-emploi';

    public function routes()
    {
        $route_collection = new RouteCollection();
        $config = new Config();

        $contentRoute = new Route(
            sprintf('/%s/{ref}', empty($config->getRoutingBase()) ? self::DEFAULT_BASE_URL : $config->getRoutingBase()),
            [
                '_controller' => 'Drupal\offres_emploi\Controller\OffresEmploiListController::show',
                'ref' => 'all',
                '_title' => 'Offres emploi'
            ],
            [
                '_permission'  => 'access content',
            ]
        );
        $route_collection->add('offresEmploi.content', $contentRoute);

        return $route_collection;
    }
}