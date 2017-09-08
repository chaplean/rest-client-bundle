<?php

namespace Chaplean\Bundle\RestClientBundle\Utility;

use Chaplean\Bundle\RestClientBundle\Api\Response\Success\PlainResponse;
use Chaplean\Bundle\RestClientBundle\Entity\RestMethodType;
use Chaplean\Bundle\RestClientBundle\Entity\RestStatusCodeType;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use GuzzleHttp\Psr7\Response;
use Mockery\Adapter\Phpunit\MockeryTestCase;

/**
 * Class RestLogUtilityTest.
 *
 * @author    Matthias - Chaplean <matthias@chaplean.coop>
 * @copyright 2014 - 2017 Chaplean (http://www.chaplean.coop)
 * @since     4.0.0
 */
class RestLogUtilityTest extends MockeryTestCase
{
    /**
     * @covers \Chaplean\Bundle\RestClientBundle\Utility\RestLogUtility::__construct()
     * @covers \Chaplean\Bundle\RestClientBundle\Utility\RestLogUtility::logResponse()
     *
     * @return void
     */
    public function testLogRequestInDatabaseIfEnabled()
    {
        $methodType = new RestMethodType();
        $this->restMethodRepo = \Mockery::mock(EntityRepository::class);
        $this->restMethodRepo->shouldReceive('findOneBy')
            ->once()
            ->with(['keyname' => 'get'])
            ->andReturn($methodType);

        $statusCodeType = new RestStatusCodeType();
        $this->restStatusCodeRepo = \Mockery::mock(EntityRepository::class);
        $this->restStatusCodeRepo->shouldReceive('findOneBy')
            ->once()
            ->with(['code' => 200])
            ->andReturn($statusCodeType);

        $this->em = \Mockery::mock(EntityManager::class);
        $this->em->shouldReceive('getRepository')
            ->once()
            ->with(RestMethodType::class)
            ->andReturn($this->restMethodRepo);

        $this->em->shouldReceive('getRepository')
            ->once()
            ->with(RestStatusCodeType::class)
            ->andReturn($this->restStatusCodeRepo);

        $this->em->shouldReceive('persist')->once();
        $this->em->shouldReceive('flush')->once();

        $this->registry = \Mockery::mock(Registry::class);
        $this->registry->shouldReceive('getManager')
            ->once()
            ->andReturn($this->em);

        $config = [
            'enable_database_logging' => true,
        ];

        $utility = new RestLogUtility($config, $this->registry);
        $utility->logResponse(new PlainResponse(new Response(200, [], ''), 'get', 'url', []));
    }

    /**
     * @covers \Chaplean\Bundle\RestClientBundle\Utility\RestLogUtility::__construct()
     * @covers \Chaplean\Bundle\RestClientBundle\Utility\RestLogUtility::logResponse()
     *
     * @return void
     */
    public function testLogRequestInDatabaseWithUnknownStatusCode()
    {
        $methodType = new RestMethodType();
        $this->restMethodRepo = \Mockery::mock(EntityRepository::class);
        $this->restMethodRepo->shouldReceive('findOneBy')
            ->once()
            ->with(['keyname' => 'get'])
            ->andReturn($methodType);

        $statusCodeType = new RestStatusCodeType();
        $this->restStatusCodeRepo = \Mockery::mock(EntityRepository::class);
        $this->restStatusCodeRepo->shouldReceive('findOneBy')
            ->once()
            ->with(['code' => 418])
            ->andReturn($statusCodeType);

        $this->em = \Mockery::mock(EntityManager::class);
        $this->em->shouldReceive('getRepository')
            ->once()
            ->with(RestMethodType::class)
            ->andReturn($this->restMethodRepo);

        $this->em->shouldReceive('getRepository')
            ->once()
            ->with(RestStatusCodeType::class)
            ->andReturn($this->restStatusCodeRepo);

        $this->em->shouldReceive('persist')->once();
        $this->em->shouldReceive('flush')->once();

        $this->registry = \Mockery::mock(Registry::class);
        $this->registry->shouldReceive('getManager')
            ->once()
            ->andReturn($this->em);

        $config = [
            'enable_database_logging' => true,
        ];

        $utility = new RestLogUtility($config, $this->registry);

        $utility->logResponse(new PlainResponse(new Response(418, [], ''), 'get', 'url', []));
    }

    /**
     * @covers \Chaplean\Bundle\RestClientBundle\Utility\RestLogUtility::__construct()
     * @covers \Chaplean\Bundle\RestClientBundle\Utility\RestLogUtility::logResponse()
     *
     * @return void
     */
    public function testDontLogRequestInDatabaseIfDisabled()
    {
        $this->em = \Mockery::mock(EntityManager::class);

        $this->registry = \Mockery::mock(Registry::class);
        $this->registry->shouldReceive('getManager')
            ->once()
            ->andReturn($this->em);

        $config = [
            'enable_database_logging' => false,
        ];

        $utility = new RestLogUtility($config, $this->registry);

        $utility->logResponse(new PlainResponse(new Response(200, [], ''), 'get', 'url', []));
    }

    /**
     * @covers \Chaplean\Bundle\RestClientBundle\Utility\RestLogUtility::__construct()
     *
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Database logging is enabled, you must register the doctrine service
     *
     * @return void
     */
    public function testConstructFailsIfConfigEnablesLoggingWithoutTheRequiredServices()
    {
        $config = [
            'enable_database_logging' => true,
        ];

        new RestLogUtility($config);
    }

    /**
     * @covers \Chaplean\Bundle\RestClientBundle\Utility\RestLogUtility::__construct()
     * @covers \Chaplean\Bundle\RestClientBundle\Utility\RestLogUtility::logResponse()
     *
     * @doesNotPerformAssertions
     *
     * @return void
     */
    public function testMissingServicesAreIgnoredIfLoggingIsDisabled()
    {
        $config = [
            'enable_database_logging' => false,
        ];

        new RestLogUtility($config);
    }
}
