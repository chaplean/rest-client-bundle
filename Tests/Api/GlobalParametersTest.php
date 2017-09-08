<?php

namespace Tests\Chaplean\Bundle\RestClientBundle\Api;

use Chaplean\Bundle\RestClientBundle\Api\GlobalParameters;
use Chaplean\Bundle\RestClientBundle\Api\Parameter;
use Chaplean\Bundle\RestClientBundle\Api\RequestRoute;
use Chaplean\Bundle\RestClientBundle\Api\Response\Success\JsonResponse;
use Chaplean\Bundle\RestClientBundle\Api\Response\Success\PlainResponse;
use Chaplean\Bundle\RestClientBundle\Api\Response\Success\XmlResponse;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Response;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class GlobalParametersTest.
 *
 * @package   Tests\Chaplean\Bundle\RestClientBundle\Api
 * @author    Matthias - Chaplean <matthias@chaplean.coop>
 * @copyright 2014 - 2017 Chaplean (http://www.chaplean.coop)
 * @since     3.0.0
 */
class GlobalParametersTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    /** @var ClientInterface */
    protected $client;

    /** @var EventDispatcherInterface */
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
     * @covers \Chaplean\Bundle\RestClientBundle\Api\GlobalParameters::__construct()
     * @covers \Chaplean\Bundle\RestClientBundle\Api\GlobalParameters::expectsPlain()
     * @covers \Chaplean\Bundle\RestClientBundle\Api\GlobalParameters::sendFormUrlEncoded()
     *
     * @return void
     */
    public function testGlobalParametersConstruct()
    {
        $globalParameter = new GlobalParameters();
        $route = new RequestRoute('POST', 'url', $this->client, $this->eventDispatcher, $globalParameter);

        $this->client->shouldReceive('request')
            ->once()
            ->with('POST', 'url', ['headers' => [], 'query' => [], 'form_params' => []])
            ->andReturn(new Response());

        $this->eventDispatcher->shouldReceive('dispatch')
            ->once();

        $this->assertInstanceOf(PlainResponse::class, $route->exec());
    }

    /**
     * @covers \Chaplean\Bundle\RestClientBundle\Api\GlobalParameters::expectsJson()
     *
     * @return void
     */
    public function testGlobalParametersExpectJson()
    {
        $globalParameter = new GlobalParameters();
        $globalParameter->expectsJson();
        $route = new RequestRoute('POST', 'url', $this->client, $this->eventDispatcher, $globalParameter);

        $this->client->shouldReceive('request')
            ->once()
            ->with('POST', 'url', ['headers' => [], 'query' => [], 'form_params' => []])
            ->andReturn(new Response());

        $this->eventDispatcher->shouldReceive('dispatch')
            ->once();

        $this->assertInstanceOf(JsonResponse::class, $route->exec());
    }

    /**
     * @covers \Chaplean\Bundle\RestClientBundle\Api\GlobalParameters::expectsXml()
     *
     * @return void
     */
    public function testGlobalParametersExpectXml()
    {
        $globalParameter = new GlobalParameters();
        $globalParameter->expectsXml();
        $route = new RequestRoute('POST', 'url', $this->client, $this->eventDispatcher, $globalParameter);

        $this->client->shouldReceive('request')
            ->once()
            ->with('POST', 'url', ['headers' => [], 'query' => [], 'form_params' => []])
            ->andReturn(new Response());

        $this->eventDispatcher->shouldReceive('dispatch')
            ->once();

        $this->assertInstanceOf(XmlResponse::class, $route->exec());
    }

    /**
     * @covers \Chaplean\Bundle\RestClientBundle\Api\GlobalParameters::sendJson()
     *
     * @return void
     */
    public function testGlobalParametersSendJson()
    {
        $globalParameter = new GlobalParameters();
        $globalParameter->sendJson();

        $route = new RequestRoute('POST', 'url', $this->client, $this->eventDispatcher, $globalParameter);

        $this->client->shouldReceive('request')
            ->once()
            ->with('POST', 'url', ['headers' => [], 'query' => [], 'json' => []])
            ->andReturn(new Response());

        $this->eventDispatcher->shouldReceive('dispatch')
            ->once();

        $this->assertInstanceOf(PlainResponse::class, $route->exec());
    }

    /**
     * @covers \Chaplean\Bundle\RestClientBundle\Api\GlobalParameters::sendXml()
     *
     * @return void
     */
    public function testGlobalParametersSendXml()
    {
        $globalParameter = new GlobalParameters();
        $globalParameter->sendXml();

        $route = new RequestRoute('POST', 'url', $this->client, $this->eventDispatcher, $globalParameter);

        $this->client->shouldReceive('request')
            ->once()
            ->with('POST', 'url', ['headers' => [], 'query' => [], 'xml' => []])
            ->andReturn(new Response());

        $this->eventDispatcher->shouldReceive('dispatch')
            ->once();

        $this->assertInstanceOf(PlainResponse::class, $route->exec());
    }

    /**
     * @covers \Chaplean\Bundle\RestClientBundle\Api\GlobalParameters::sendJSONString()
     *
     * @return void
     */
    public function testGlobalParametersSendJSONString()
    {
        $globalParameter = new GlobalParameters();
        $globalParameter->sendJSONString();

        $route = new RequestRoute('POST', 'url', $this->client, $this->eventDispatcher, $globalParameter);

        $this->client->shouldReceive('request')
            ->once()
            ->with('POST', 'url', ['headers' => [], 'query' => [], 'form_params' => ['JSONString' => '[]']])
            ->andReturn(new Response());

        $this->eventDispatcher->shouldReceive('dispatch')
            ->once();

        $this->assertInstanceOf(PlainResponse::class, $route->exec());
    }

    /**
     * @covers \Chaplean\Bundle\RestClientBundle\Api\GlobalParameters::urlPrefix()
     *
     * @return void
     */
    public function testGlobalParametersUrlPrefix()
    {
        $globalParameter = new GlobalParameters();
        $globalParameter->urlPrefix('prefix');

        $route = new RequestRoute('POST', 'url', $this->client, $this->eventDispatcher, $globalParameter);

        $this->client->shouldReceive('request')
            ->once()
            ->with('POST', 'prefixurl', ['headers' => [], 'query' => [], 'form_params' => []])
            ->andReturn(new Response());

        $this->eventDispatcher->shouldReceive('dispatch')
            ->once();

        $this->assertInstanceOf(PlainResponse::class, $route->exec());
    }

    /**
     * @covers \Chaplean\Bundle\RestClientBundle\Api\GlobalParameters::urlParameters()
     *
     * @return void
     */
    public function testGlobalParametersUrlParameters()
    {
        $globalParameter = new GlobalParameters();
        $globalParameter->urlParameters(['id' => Parameter::id()]);

        $route = new RequestRoute('POST', 'url/{id}', $this->client, $this->eventDispatcher, $globalParameter);
        $route->bindUrlParameters(['id' => 42]);

        $this->client->shouldReceive('request')
            ->once()
            ->with('POST', 'url/42', ['headers' => [], 'query' => [], 'form_params' => []])
            ->andReturn(new Response());

        $this->eventDispatcher->shouldReceive('dispatch')
            ->once();

        $this->assertInstanceOf(PlainResponse::class, $route->exec());
    }

    /**
     * @covers \Chaplean\Bundle\RestClientBundle\Api\GlobalParameters::queryParameters()
     *
     * @return void
     */
    public function testGlobalParametersQueryParameters()
    {
        $globalParameter = new GlobalParameters();
        $globalParameter->queryParameters(['id' => Parameter::id()]);

        $route = new RequestRoute('POST', 'url', $this->client, $this->eventDispatcher, $globalParameter);
        $route->bindQueryParameters(['id' => 42]);

        $this->client->shouldReceive('request')
            ->once()
            ->with('POST', 'url', ['headers' => [], 'query' => ['id' => 42], 'form_params' => []])
            ->andReturn(new Response());

        $this->eventDispatcher->shouldReceive('dispatch')
            ->once();

        $this->assertInstanceOf(PlainResponse::class, $route->exec());
    }

    /**
     * @covers \Chaplean\Bundle\RestClientBundle\Api\GlobalParameters::headers()
     *
     * @return void
     */
    public function testGlobalParametersHeaders()
    {
        $globalParameter = new GlobalParameters();
        $globalParameter->headers(['id' => Parameter::id()]);

        $route = new RequestRoute('POST', 'url', $this->client, $this->eventDispatcher, $globalParameter);
        $route->bindHeaders(['id' => 42]);

        $this->client->shouldReceive('request')
            ->once()
            ->with('POST', 'url', ['headers' => ['id' => 42], 'query' => [], 'form_params' => []])
            ->andReturn(new Response());

        $this->eventDispatcher->shouldReceive('dispatch')
            ->once();

        $this->assertInstanceOf(PlainResponse::class, $route->exec());
    }

    /**
     * @covers \Chaplean\Bundle\RestClientBundle\Api\GlobalParameters::requestParameters()
     *
     * @return void
     */
    public function testGlobalParametersRequestParameters()
    {
        $globalParameter = new GlobalParameters();
        $globalParameter->requestParameters(['id' => Parameter::id()]);

        $route = new RequestRoute('POST', 'url', $this->client, $this->eventDispatcher, $globalParameter);
        $route->bindRequestParameters(['id' => 42]);

        $this->client->shouldReceive('request')
            ->once()
            ->with('POST', 'url', ['headers' => [], 'query' => [], 'form_params' => ['id' => 42]])
            ->andReturn(new Response());

        $this->eventDispatcher->shouldReceive('dispatch')
            ->once();

        $this->assertInstanceOf(PlainResponse::class, $route->exec());
    }
}
