<?php

namespace Chaplean\Bundle\RestClientBundle\Utility;

use Chaplean\Bundle\RestClientBundle\Api\Response\Success\PlainResponse;
use Chaplean\Bundle\RestClientBundle\Entity\RestMethodType;
use Chaplean\Bundle\RestClientBundle\Entity\RestStatusCodeType;
use Chaplean\Bundle\RestClientBundle\Query\RestLogQuery;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\ORM\AbstractQuery;
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
        $restMethodRepo = \Mockery::mock(EntityRepository::class);
        $restMethodRepo->shouldReceive('findOneBy')->once()->with(['keyname' => 'get'])->andReturn($methodType);

        $statusCodeType = new RestStatusCodeType();
        $restStatusCodeRepo = \Mockery::mock(EntityRepository::class);
        $restStatusCodeRepo->shouldReceive('findOneBy')->once()->with(['code' => 200])->andReturn($statusCodeType);

        $em = \Mockery::mock(EntityManager::class);
        $em->shouldReceive('getRepository')->once()->with(RestMethodType::class)->andReturn($restMethodRepo);

        $em->shouldReceive('getRepository')->once()->with(RestStatusCodeType::class)->andReturn($restStatusCodeRepo);

        $em->shouldReceive('persist')->once();
        $em->shouldReceive('flush')->once();

        $restLogQuery = \Mockery::mock(RestLogQuery::class);
        $registry = \Mockery::mock(Registry::class);
        $registry->shouldReceive('getManager')->once()->andReturn($em);

        $config = [
            'enable_database_logging' => true,
        ];

        $utility = new RestLogUtility($config, $restLogQuery, $registry);
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
        $restMethodRepo = \Mockery::mock(EntityRepository::class);
        $restMethodRepo->shouldReceive('findOneBy')->once()->with(['keyname' => 'get'])->andReturn($methodType);

        $statusCodeType = new RestStatusCodeType();
        $restStatusCodeRepo = \Mockery::mock(EntityRepository::class);
        $restStatusCodeRepo->shouldReceive('findOneBy')->once()->with(['code' => 418])->andReturn($statusCodeType);

        $em = \Mockery::mock(EntityManager::class);
        $em->shouldReceive('getRepository')->once()->with(RestMethodType::class)->andReturn($restMethodRepo);

        $em->shouldReceive('getRepository')->once()->with(RestStatusCodeType::class)->andReturn($restStatusCodeRepo);

        $em->shouldReceive('persist')->once();
        $em->shouldReceive('flush')->once();

        $restLogQuery = \Mockery::mock(RestLogQuery::class);
        $registry = \Mockery::mock(Registry::class);
        $registry->shouldReceive('getManager')->once()->andReturn($em);

        $config = [
            'enable_database_logging' => true,
        ];

        $utility = new RestLogUtility($config, $restLogQuery, $registry);

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
        $em = \Mockery::mock(EntityManager::class);

        $restLogQuery = \Mockery::mock(RestLogQuery::class);
        $registry = \Mockery::mock(Registry::class);
        $registry->shouldReceive('getManager')->once()->andReturn($em);

        $config = [
            'enable_database_logging' => false,
        ];

        $utility = new RestLogUtility($config, $restLogQuery, $registry);

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
        $restLogQuery = \Mockery::mock(RestLogQuery::class);

        $config = [
            'enable_database_logging' => true,
        ];

        new RestLogUtility($config, $restLogQuery);
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
        $restLogQuery = \Mockery::mock(RestLogQuery::class);

        $config = [
            'enable_database_logging' => false,
        ];

        new RestLogUtility($config, $restLogQuery);
    }

    /**
     * @covers \Chaplean\Bundle\RestClientBundle\Utility\RestLogUtility::__construct()
     * @covers \Chaplean\Bundle\RestClientBundle\Utility\RestLogUtility::deleteMostRecentThan()
     *
     * @return void
     */
    public function testDeleteMostRecentThan()
    {
        $date = new \DateTime();
        $em = \Mockery::mock(EntityManager::class);
        $querySearch = \Mockery::mock(AbstractQuery::class);
        $queryDelete = \Mockery::mock(AbstractQuery::class);
        $restLogQuery = \Mockery::mock(RestLogQuery::class);
        $registry = \Mockery::mock(Registry::class);

        $config = [
            'enable_database_logging' => true,
        ];

        $registry->shouldReceive('getManager')->once()->andReturn($em);
        $restLogQuery->shouldReceive('createFindIdsMostRecentThan')->once()->with($date)->andReturn($querySearch);
        $querySearch->shouldReceive('getResult')->once()->andReturn([['id' => 125], ['id' => 126]]);
        $restLogQuery->shouldReceive('createDeleteById')->once()->with(125)->andReturn($queryDelete);
        $queryDelete->shouldReceive('execute')->once()->andReturnNull();
        $restLogQuery->shouldReceive('createDeleteById')->once()->with(126)->andReturn($queryDelete);
        $queryDelete->shouldReceive('execute')->once()->andThrow(new \Exception());

        $utility = new RestLogUtility($config, $restLogQuery, $registry);
        $result = $utility->deleteMostRecentThan($date);

        $this->assertEquals(1, $result);
    }
}
