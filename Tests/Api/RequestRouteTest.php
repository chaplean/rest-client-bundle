<?php

namespace Tests\Chaplean\Bundle\RestClientBundle\Api;

use Chaplean\Bundle\RestClientBundle\Api\GlobalParameters;
use Chaplean\Bundle\RestClientBundle\Api\Parameter;
use Chaplean\Bundle\RestClientBundle\Api\RequestRoute;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Response;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
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
class RequestRouteTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    /**
     * @var Client
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

        $this->client = \Mockery::mock(ClientInterface::class);
        $this->eventDispatcher = \Mockery::mock(EventDispatcherInterface::class);
    }

    /**
     * @covers \Chaplean\Bundle\RestClientBundle\Api\RequestRoute::requestParameters()
     * @covers \Chaplean\Bundle\RestClientBundle\Api\RequestRoute::bindRequestParameters()
     * @covers \Chaplean\Bundle\RestClientBundle\Api\RequestRoute::__construct()
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
                'POST',
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
                    'form_params' => [
                        'value5' => 5,
                        'value6' => 6,
                    ],
                ]
            )
            ->andReturn(new Response());

        $route = new RequestRoute(Request::METHOD_POST, 'url', $this->client, $this->eventDispatcher, new GlobalParameters());
        $route->headers(['value1' => Parameter::int(), 'value2' => Parameter::int()]);
        $route->queryParameters(['value3' => Parameter::int(), 'value4' => Parameter::int()]);
        $route->requestParameters(['value5' => Parameter::int(), 'value6' => Parameter::int()]);
        $route->bindHeaders(['value1' => 1, 'value2' => 2]);
        $route->bindQueryParameters(['value3' => 3, 'value4' => 4]);
        $route->bindRequestParameters(['value5' => 5, 'value6' => 6]);

        $route->exec();
    }

    /**
     * @covers \Chaplean\Bundle\RestClientBundle\Api\RequestRoute::requestParameters()
     * @covers \Chaplean\Bundle\RestClientBundle\Api\RequestRoute::bindRequestParameters()
     * @covers \Chaplean\Bundle\RestClientBundle\Api\RequestRoute::sendJson()
     * @covers \Chaplean\Bundle\RestClientBundle\Api\RequestRoute::__construct()
     *
     * @return void
     */
    public function testBuildRequestOptionsJson()
    {
        $this->eventDispatcher->shouldReceive('dispatch')
            ->once();

        $this->client->shouldReceive('request')
            ->once()
            ->with(
                'POST',
                'url',
                [
                    'headers' => [],
                    'query'   => [],
                    'json'    => [
                        'value' => 42,
                    ],
                ]
            )
            ->andReturn(new Response());

        $route = new RequestRoute(Request::METHOD_POST, 'url', $this->client, $this->eventDispatcher, new GlobalParameters());
        $route->requestParameters(['value' => Parameter::int()]);
        $route->sendJson();
        $route->bindRequestParameters(['value' => 42]);

        $route->exec();
    }

    /**
     * @covers \Chaplean\Bundle\RestClientBundle\Api\RequestRoute::requestParameters()
     * @covers \Chaplean\Bundle\RestClientBundle\Api\RequestRoute::bindRequestParameters()
     * @covers \Chaplean\Bundle\RestClientBundle\Api\RequestRoute::sendXml()
     * @covers \Chaplean\Bundle\RestClientBundle\Api\RequestRoute::__construct()
     *
     * @return void
     */
    public function testBuildRequestOptionsXml()
    {
        $this->eventDispatcher->shouldReceive('dispatch')
            ->once();

        $this->client->shouldReceive('request')
            ->once()
            ->with(
                'POST',
                'url',
                [
                    'headers' => [],
                    'query'   => [],
                    'xml'     => [
                        'value' => 42,
                    ],
                ]
            )
            ->andReturn(new Response());

        $route = new RequestRoute(Request::METHOD_POST, 'url', $this->client, $this->eventDispatcher, new GlobalParameters());
        $route->requestParameters(['value' => Parameter::int()]);
        $route->sendXml();
        $route->bindRequestParameters(['value' => 42]);

        $route->exec();
    }

    /**
     * @covers \Chaplean\Bundle\RestClientBundle\Api\RequestRoute::buildRequestParameters()
     *
     * @return void
     */
    public function testBuildRequestParametersWithJSONString()
    {
        $this->eventDispatcher->shouldReceive('dispatch')
            ->once();

        $this->client->shouldReceive('request')
            ->once()
            ->with(
                'POST',
                'url',
                [
                    'headers' => [],
                    'query'   => [],
                    'form_params'     => [
                        'JSONString' => '{"value":42}'
                    ],
                ]
            )
            ->andReturn(new Response());

        $route = new RequestRoute(Request::METHOD_POST, 'url', $this->client, $this->eventDispatcher, new GlobalParameters());
        $route->requestParameters(['value' => Parameter::int()]);
        $route->sendJSONString();
        $route->bindRequestParameters(['value' => 42]);

        $route->exec();
    }

    /**
     * @covers \Chaplean\Bundle\RestClientBundle\Api\RequestRoute::buildRequestParameters()
     *
     * @return void
     */
    public function testBuildRequestParametersWithUrlEncoded()
    {
        $this->eventDispatcher->shouldReceive('dispatch')
            ->once();

        $this->client->shouldReceive('request')
            ->once()
            ->with(
                'POST',
                'url',
                [
                    'headers' => [],
                    'query'   => [],
                    'form_params'     => [
                        'value' => 42
                    ],
                ]
            )
            ->andReturn(new Response());

        $route = new RequestRoute(Request::METHOD_POST, 'url', $this->client, $this->eventDispatcher, new GlobalParameters());
        $route->requestParameters(['value' => Parameter::int()]);
        $route->sendFormUrlEncoded();
        $route->bindRequestParameters(['value' => 42]);

        $route->exec();
    }
}
