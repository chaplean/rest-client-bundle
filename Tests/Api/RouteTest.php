<?php

namespace Tests\Chaplean\Bundle\RestClientBundle\Api;

use Chaplean\Bundle\RestClientBundle\Api\GlobalParameters;
use Chaplean\Bundle\RestClientBundle\Api\Parameter;
use Chaplean\Bundle\RestClientBundle\Api\Response\Failure\AbstractFailureResponse;
use Chaplean\Bundle\RestClientBundle\Api\Response\Failure\InvalidParameterResponse;
use Chaplean\Bundle\RestClientBundle\Api\Response\Failure\RequestFailedResponse;
use Chaplean\Bundle\RestClientBundle\Api\Response\Success\AbstractSuccessResponse;
use Chaplean\Bundle\RestClientBundle\Api\Response\Success\JsonResponse;
use Chaplean\Bundle\RestClientBundle\Api\Response\Success\PlainResponse;
use Chaplean\Bundle\RestClientBundle\Api\Response\Success\XmlResponse;
use Chaplean\Bundle\RestClientBundle\Api\Route;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\TransferException;
use GuzzleHttp\Psr7\Response;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class RouteTest.
 *
 * @package   Tests\Chaplean\Bundle\RestClientBundle\Api
 * @author    Matthias - Chaplean <matthias@chaplean.coop>
 * @copyright 2014 - 2017 Chaplean (http://www.chaplean.coop)
 * @since     3.0.0
 */
class RouteTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    /**
     * @var MockInterface
     */
    protected $client;

    /**
     * @var EventDispatcherInterface
     */
    protected $eventDispatcher;

    /**
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->client = \Mockery::mock(Client::class);
        $this->eventDispatcher = \Mockery::mock(EventDispatcherInterface::class);
    }

    /**
     * @covers \Chaplean\Bundle\RestClientBundle\Api\Route::__construct()
     *
     * @expectedException \InvalidArgumentException
     *
     * @return void
     */
    public function testConstructInvalidArguments()
    {
        new Route('la méthode', 'url', $this->client, $this->eventDispatcher, new GlobalParameters());
    }

    /**
     * @covers \Chaplean\Bundle\RestClientBundle\Api\Route::__construct()
     * @covers \Chaplean\Bundle\RestClientBundle\Api\Route::fillInUrlPlaceholders()
     *
     * @return void
     */
    public function testFillInUrlPlaceholdersNoPlaceholder()
    {
        $this->eventDispatcher->shouldReceive('dispatch')
            ->once();

        $this->client->shouldReceive('request')
            ->once()
            ->with('GET', 'url', ['headers' => [], 'query' => []])
            ->andReturn(new Response());

        $route = new Route(Request::METHOD_GET, '/url', $this->client, $this->eventDispatcher, new GlobalParameters());

        $route->exec();
    }

    /**
     * @covers \Chaplean\Bundle\RestClientBundle\Api\Route::urlParameters()
     * @covers \Chaplean\Bundle\RestClientBundle\Api\Route::bindUrlParameters()
     * @covers \Chaplean\Bundle\RestClientBundle\Api\Route::__construct()
     * @covers \Chaplean\Bundle\RestClientBundle\Api\Route::fillInUrlPlaceholders()
     *
     * @return void
     */
    public function testFillInUrlPlaceholdersWithPlaceholders()
    {
        $this->eventDispatcher->shouldReceive('dispatch')
            ->once();

        $this->client->shouldReceive('request')
            ->once()
            ->with('GET', 'url/with/1/and/2/placeholder', ['headers' => [], 'query' => []])
            ->andReturn(new Response());

        $route = new Route(Request::METHOD_GET, 'url/with/{placeholder}/and/{another}/placeholder', $this->client, $this->eventDispatcher, new GlobalParameters());
        $route->urlParameters(['placeholder' => Parameter::int(), 'another' => Parameter::int()]);
        $route->bindUrlParameters(['placeholder' => 1, 'another' => 2]);

        $route->exec();
    }

    /**
     * @covers \Chaplean\Bundle\RestClientBundle\Api\Route::urlParameters()
     * @covers \Chaplean\Bundle\RestClientBundle\Api\Route::bindUrlParameters()
     * @covers \Chaplean\Bundle\RestClientBundle\Api\Route::__construct()
     * @covers \Chaplean\Bundle\RestClientBundle\Api\Route::fillInUrlPlaceholders()
     *
     * @return void
     */
    public function testFillInUrlPlaceholdersWithPlaceholdersComposed()
    {
        $this->eventDispatcher->shouldReceive('dispatch')
            ->once();

        $this->client->shouldReceive('request')
            ->once()
            ->with('GET', 'url/with/1/and/2.json', ['headers' => [], 'query' => []])
            ->andReturn(new Response());

        $route = new Route(Request::METHOD_GET, 'url/with/{placeholder}/and/{another}.json', $this->client, $this->eventDispatcher, new GlobalParameters());
        $route->urlParameters(['placeholder' => Parameter::int(), 'another' => Parameter::int()]);
        $route->bindUrlParameters(['placeholder' => 1, 'another' => 2]);

        $route->exec();
    }

    /**
     * @covers \Chaplean\Bundle\RestClientBundle\Api\Route::urlParameters()
     * @covers \Chaplean\Bundle\RestClientBundle\Api\Route::__construct()
     * @covers \Chaplean\Bundle\RestClientBundle\Api\Route::fillInUrlPlaceholders()
     *
     * @return void
     */
    public function testFillInUrlPlaceholdersWithInvalidData()
    {
        $this->eventDispatcher->shouldReceive('dispatch')
            ->once();

        $route = new Route(Request::METHOD_GET, 'url/with/{placeholder}/and/{another}/placeholder', $this->client, $this->eventDispatcher, new GlobalParameters());
        $route->urlParameters(['placeholder' => Parameter::int(), 'another' => Parameter::int()]);

        $this->assertInstanceOf(InvalidParameterResponse::class, $route->exec());
    }

    /**
     * @covers \Chaplean\Bundle\RestClientBundle\Api\Route::headers()
     * @covers \Chaplean\Bundle\RestClientBundle\Api\Route::queryParameters()
     * @covers \Chaplean\Bundle\RestClientBundle\Api\Route::bindHeaders()
     * @covers \Chaplean\Bundle\RestClientBundle\Api\Route::bindQueryParameters()
     * @covers \Chaplean\Bundle\RestClientBundle\Api\Route::buildRequestOptions()
     * @covers \Chaplean\Bundle\RestClientBundle\Api\Route::__construct()
     *
     * @return void
     */
    public function testBuildRequestOptions()
    {
        $this->eventDispatcher->shouldReceive('dispatch')
            ->once();

        $this->client->shouldReceive('request')
            ->once()
            ->with(
                'GET',
                'url',
                [
                    'headers' => [
                        'value1' => 1,
                        'value2' => 2,
                    ],
                    'query'   => [
                        'value3' => 3,
                        'value4' => 4,
                    ],
                ]
            )
            ->andReturn(new Response());

        $route = new Route(Request::METHOD_GET, 'url', $this->client, $this->eventDispatcher, new GlobalParameters());
        $route->headers(['value1' => Parameter::int(), 'value2' => Parameter::int()]);
        $route->queryParameters(['value3' => Parameter::int(), 'value4' => Parameter::int()]);
        $route->bindHeaders(['value1' => 1, 'value2' => 2]);
        $route->bindQueryParameters(['value3' => 3, 'value4' => 4]);

        $route->exec();
    }

    /**
     * @covers \Chaplean\Bundle\RestClientBundle\Api\Route::headers()
     * @covers \Chaplean\Bundle\RestClientBundle\Api\Route::queryParameters()
     * @covers \Chaplean\Bundle\RestClientBundle\Api\Route::__construct()
     *
     * @return void
     */
    public function testBuildRequestOptionsWithInvalidParameters()
    {
        $this->eventDispatcher->shouldReceive('dispatch')
            ->once();

        $route = new Route(Request::METHOD_GET, 'url', $this->client, $this->eventDispatcher, new GlobalParameters());
        $route->headers(['value1' => Parameter::int(), 'value2' => Parameter::int()]);
        $route->queryParameters(['value3' => Parameter::int(), 'value4' => Parameter::int()]);

        $this->assertInstanceOf(InvalidParameterResponse::class, $route->exec());
    }

    /**
     * @covers \Chaplean\Bundle\RestClientBundle\Api\Route::headers()
     * @covers \Chaplean\Bundle\RestClientBundle\Api\Route::exec()
     * @covers \Chaplean\Bundle\RestClientBundle\Api\Route::sendRequest()
     * @covers \Chaplean\Bundle\RestClientBundle\Api\Route::__construct()
     * @covers \Chaplean\Bundle\RestClientBundle\Api\Route::getViolations()
     *
     * @return void
     */
    public function testExecWithInvalidParameters()
    {
        $this->client->shouldReceive('request')->never();
        $this->eventDispatcher->shouldReceive('dispatch')->once();

        $route = new Route(Request::METHOD_GET, 'url', $this->client, $this->eventDispatcher, new GlobalParameters());
        $route->headers(['value1' => Parameter::int(), 'value2' => Parameter::int()]);

        $response = $route->exec();

        $this->assertInstanceOf(InvalidParameterResponse::class, $response);
    }

    /**
     * @covers \Chaplean\Bundle\RestClientBundle\Api\Route::exec()
     * @covers \Chaplean\Bundle\RestClientBundle\Api\Route::sendRequest()
     * @covers \Chaplean\Bundle\RestClientBundle\Api\Route::__construct()
     *
     * @return void
     */
    public function testExec()
    {
        $this->client->shouldReceive('request')->once()->andReturn(new Response());
        $this->eventDispatcher->shouldReceive('dispatch')->once();

        $route = new Route(Request::METHOD_GET, 'url', $this->client, $this->eventDispatcher, new GlobalParameters());

        $response = $route->exec();

        $this->assertInstanceOf(PlainResponse::class, $response);
    }

    /**
     * @covers \Chaplean\Bundle\RestClientBundle\Api\Route::expectsJson()
     * @covers \Chaplean\Bundle\RestClientBundle\Api\Route::exec()
     * @covers \Chaplean\Bundle\RestClientBundle\Api\Route::sendRequest()
     * @covers \Chaplean\Bundle\RestClientBundle\Api\Route::__construct()
     *
     * @return void
     */
    public function testExecJson()
    {
        $this->client->shouldReceive('request')->once()->andReturn(new Response());
        $this->eventDispatcher->shouldReceive('dispatch')->once();

        $route = new Route(Request::METHOD_GET, 'url', $this->client, $this->eventDispatcher, new GlobalParameters());
        $route->expectsJson();

        $response = $route->exec();

        $this->assertInstanceOf(JsonResponse::class, $response);
    }

    /**
     * @covers \Chaplean\Bundle\RestClientBundle\Api\Route::expectsXml()
     * @covers \Chaplean\Bundle\RestClientBundle\Api\Route::exec()
     * @covers \Chaplean\Bundle\RestClientBundle\Api\Route::sendRequest()
     * @covers \Chaplean\Bundle\RestClientBundle\Api\Route::__construct()
     *
     * @return void
     */
    public function testExecXml()
    {
        $this->client->shouldReceive('request')->once()->andReturn(new Response());
        $this->eventDispatcher->shouldReceive('dispatch')->once();

        $route = new Route(Request::METHOD_GET, 'url', $this->client, $this->eventDispatcher, new GlobalParameters());
        $route->expectsXml();

        $response = $route->exec();

        $this->assertInstanceOf(XmlResponse::class, $response);
    }

    /**
     * @covers \Chaplean\Bundle\RestClientBundle\Api\Route::expectsXml()
     * @covers \Chaplean\Bundle\RestClientBundle\Api\Route::exec()
     * @covers \Chaplean\Bundle\RestClientBundle\Api\Route::sendRequest()
     * @covers \Chaplean\Bundle\RestClientBundle\Api\Route::__construct()
     *
     * @return void
     */
    public function testExecRequestFailed()
    {
        $this->client->shouldReceive('request')->once()->andThrow(new TransferException());
        $this->eventDispatcher->shouldReceive('dispatch')->once();

        $route = new Route(Request::METHOD_GET, 'url', $this->client, $this->eventDispatcher, new GlobalParameters());
        $route->expectsXml();

        $response = $route->exec();

        $this->assertInstanceOf(RequestFailedResponse::class, $response);
    }

    /**
     * @covers \Chaplean\Bundle\RestClientBundle\Api\Route::getUrl()
     * @covers \Chaplean\Bundle\RestClientBundle\Api\Route::__construct()
     *
     * @return void
     */
    public function testGetUrl()
    {
        $route = new Route(Request::METHOD_GET, 'url', $this->client, $this->eventDispatcher, new GlobalParameters());

        $url = $route->getUrl();

        $this->assertEquals('url', $url);
    }

    /**
     * @covers \Chaplean\Bundle\RestClientBundle\Api\Route::getUrl()
     * @covers \Chaplean\Bundle\RestClientBundle\Api\Route::__construct()
     * @covers \Chaplean\Bundle\RestClientBundle\Api\Route::getMethod()
     *
     * @return void
     */
    public function testGetMethod()
    {
        $route = new Route(Request::METHOD_GET, 'url', $this->client, $this->eventDispatcher, new GlobalParameters());

        $method = $route->getMethod();

        $this->assertEquals(Request::METHOD_GET, $method);
    }

    /**
     * @covers \Chaplean\Bundle\RestClientBundle\Api\Route::expectsPlain()
     * @covers \Chaplean\Bundle\RestClientBundle\Api\Route::__construct()
     *
     * @return void
     */
    public function testExpectsPlain()
    {
        $this->eventDispatcher->shouldReceive('dispatch')
            ->once();

        $this->client->shouldReceive('request')
            ->once()
            ->with('GET', 'url', ['headers' => [], 'query' => []])
            ->andReturn(new Response());

        $route = new Route(Request::METHOD_GET, 'url', $this->client, $this->eventDispatcher, new GlobalParameters());
        $route->expectsPlain();

        $this->assertInstanceOf(PlainResponse::class, $route->exec());
    }

    /**
     * @covers \Chaplean\Bundle\RestClientBundle\Api\Route::sendRequest()
     *
     * @return void
     */
    public function testRequestSucceedingWithAHttpErrorCodeAreStillSuccessRequest()
    {
        $this->eventDispatcher->shouldReceive('dispatch')
            ->once();

        $this->client->shouldReceive('request')->once()->andThrow(RequestException::create(new \GuzzleHttp\Psr7\Request('test', 'get'), new Response(500)));
        $route = new Route(Request::METHOD_GET, 'url', $this->client, $this->eventDispatcher, new GlobalParameters());

        $this->assertInstanceOf(AbstractSuccessResponse::class, $route->exec());
    }

    /**
     * @covers \Chaplean\Bundle\RestClientBundle\Api\Route::sendRequest()
     *
     * @return void
     */
    public function testRequestWithRequestExceptionAndNoResponse()
    {
        $this->eventDispatcher->shouldReceive('dispatch')
            ->once();

        $this->client->shouldReceive('request')->once()->andThrow(RequestException::create(new \GuzzleHttp\Psr7\Request('test', 'get')));
        $route = new Route(Request::METHOD_GET, 'url', $this->client, $this->eventDispatcher, new GlobalParameters());

        $this->assertInstanceOf(AbstractFailureResponse::class, $route->exec());
    }
}
