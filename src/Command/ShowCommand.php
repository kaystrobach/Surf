<?php
namespace TYPO3\Surf\Command;

/*                                                                        *
 * This script belongs to the TYPO3 project "TYPO3 Surf".                 *
 *                                                                        *
 *                                                                        */

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use TYPO3\Surf\Integration\FactoryAwareInterface;
use TYPO3\Surf\Integration\FactoryAwareTrait;

/**
 * Surf list command
 */
class ShowCommand extends Command implements FactoryAwareInterface
{
    use FactoryAwareTrait;

    /**
     * Configure
     */
    protected function configure()
    {
        $this->setName('show')
            ->addOption(
                'configurationPath',
                null,
                InputOption::VALUE_OPTIONAL,
                'Path for deployment configuration files'
            );
    }

    /**
     * Execute
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $configurationPath = $input->getOption('configurationPath');
        $deploymentNames = $this->factory->getDeploymentNames($configurationPath);

        $output->writeln(sprintf(PHP_EOL . '<u>Deployments in "%s":</u>' . PHP_EOL, $this->factory->getDeploymentsBasePath($configurationPath)));
        foreach ($deploymentNames as $deploymentName) {
            $line = sprintf('  <info>%s</info>', $deploymentName);
            $output->writeln($line);
        }
        $output->writeln('');
    }
}
