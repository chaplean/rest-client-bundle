<?php

namespace Chaplean\Bundle\RestClientBundle\Command;

use Chaplean\Bundle\RestClientBundle\Utility\RestLogUtility;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ChapleanRestLogCleanCommand.
 *
 * @package   Chaplean\Bundle\RestClientBundle\Command
 * @author    Hugo - Chaplean <hugo@chaplean.com>
 * @copyright 2014 - 2018 Chaplean (http://www.chaplean.com)
 */
class ChapleanRestLogCleanCommand extends ContainerAwareCommand
{
    /**
     * Configures the current command.
     *
     * @return void
     */
    protected function configure()
    {
        $this->setName('chaplean:rest-log:clean');
        $this->setDescription('Delete logs older than one month');
    }

    /**
     * Execute command
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var RestLogUtility $restLogUtility */
        $restLogUtility = $this->getContainer()->get('chaplean_rest_client.utility.rest_log');

        $dateLimit = new \DateTime('now - 1 month midnight');
        $restLogsDeleted = $restLogUtility->deleteMostRecentThan($dateLimit);

        $output->writeln($restLogsDeleted . ' logs removed');
    }
}
