<?php
namespace Drupal\c2e_produits\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Drupal\Console\Core\Command\Command;

use Drupal\c2e_produits\Controller\ProductController;

/**
 * Class CheckCommand.
 *
 * Drupal\Console\Annotations\DrupalCommand (
 *     extension="c2e_produits",
 *     extensionType="module"
 * )
 */
class CheckCommand extends Command
{
    const COMMAND_NAME = 'c2e_produits:check';

    protected function configure()
    {
        $this->setName(self::COMMAND_NAME)
            ->setDescription('Check CSV file, products, and pictures');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $controllerProduct = new ProductController();

        $controllerProduct->check("S0");
        $controllerProduct->check("S1");

        $controllerProduct->alertTeam();
    }
}