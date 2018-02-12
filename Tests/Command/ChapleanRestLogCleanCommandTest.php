<?php

namespace Tests\Chaplean\Bundle\RestClientBundle\Command;

use Chaplean\Bundle\RestClientBundle\Command\ChapleanRestLogCleanCommand;
use Chaplean\Bundle\RestClientBundle\Utility\RestLogUtility;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class ChapleanRestLogCleanCommandTest.
 *
 * @package   Tests\Chaplean\Bundle\RestClientBundle\Command
 * @author    Hugo - Chaplean <hugo@chaplean.com>
 * @copyright 2014 - 2018 Chaplean (http://www.chaplean.com)
 */
class ChapleanRestLogCleanCommandTest extends MockeryTestCase
{
    /**
     * @covers \Chaplean\Bundle\RestClientBundle\Command\ChapleanRestLogCleanCommand::configure()
     * @covers \Chaplean\Bundle\RestClientBundle\Command\ChapleanRestLogCleanCommand::execute()
     *
     * @return void
     */
    public function testExecute()
    {
        $mockRestLogUtility = \Mockery::mock(RestLogUtility::class);

        $container = \Mockery::mock(ContainerInterface::class);
        $container->shouldReceive('get')
            ->once()
            ->with('chaplean_rest_client.utility.rest_log')
            ->andReturn($mockRestLogUtility);

        $mockRestLogUtility->shouldReceive('deleteMostRecentThan')->andReturn(15);

        $command = new ChapleanRestLogCleanCommand();
        $command->setContainer($container);

        $input = new ArgvInput([]);
        $output = new NullOutput();
        $command->run($input, $output);
    }
}
