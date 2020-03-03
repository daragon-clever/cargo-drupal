<?php
namespace Drupal\c2e_produits\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Drupal\Console\Core\Command\Command;

use Drupal\c2e_produits\Controller\FluxRssController;

/**
 * Class FluxRssCommand.
 *
 * Drupal\Console\Annotations\DrupalCommand (
 *     extension="c2e_produits",
 *     extensionType="module"
 * )
 */
class FluxRssCommand extends Command
{
    const COMMAND_NAME = 'c2e_produits:generate-flux-rss';

    protected function configure()
    {
        $this->setName(self::COMMAND_NAME)
            ->setDescription('Generate Product RSS Flux');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $controllerFluxRss = new FluxRssController();
        $controllerFluxRss->generateFlux();
    }
}