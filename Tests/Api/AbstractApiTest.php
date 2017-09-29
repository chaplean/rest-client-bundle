<?php

namespace Tests\Chaplean\Bundle\RestClientBundle\Api;

use Chaplean\Bundle\RestClientBundle\Api\Route;
use Chaplean\Bundle\RestClientBundle\Tests\Resources\Api\TestApi;
use Chaplean\Bundle\RestClientBundle\Tests\Resources\Api\WithoutGlobalParametersTestApi;
use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class AbstractApiTest.
 *
 * @package   Tests\Chaplean\Bundle\RestClientBundle\Api
 * @author    Matthias - Chaplean <matthias@chaplean.coop>
 * @copyright 2014 - 2017 Chaplean (http://www.chaplean.coop)
 * @since     3.0.0
 */
class AbstractApiTest extends TestCase
{
    /**
     * @var EventDispatcher
     */
    protected $eventDispatcher;

    /**
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->eventDispatcher = \Mockery::mock(EventDispatcherInterface::class);
    }

    /**
     * @covers \Chaplean\Bundle\RestClientBundle\Api\AbstractApi::__call
     *
     * @expectedException \Exception
     * @expectedExceptionMessage invalidCall is invalid, it should start with a HTTP verb
     *
     * @return void
     */
    public function testInvalidCall()
    {
        $api = new TestApi(new Client(), $this->eventDispatcher);
        $api->invalidCall();
    }

    /**
     * @covers \Chaplean\Bundle\RestClientBundle\Api\AbstractApi::globalParameters()
     *
     * @expectedException \LogicException
     * @expectedExceptionMessage globalParameters() must be called before any route definition
     *
     * @return void
     */
    public function testGlobalParametersCalledAfterRouteDefined()
    {
        $api = new WithoutGlobalParametersTestApi(new Client(), $this->eventDispatcher);
        $api->globalParameters();
    }

    /**
     * @covers \Chaplean\Bundle\RestClientBundle\Api\AbstractApi::globalParameters()
     * @covers \Chaplean\Bundle\RestClientBundle\Api\AbstractApi::get()
     * @covers \Chaplean\Bundle\RestClientBundle\Api\AbstractApi::post()
     * @covers \Chaplean\Bundle\RestClientBundle\Api\AbstractApi::put()
     * @covers \Chaplean\Bundle\RestClientBundle\Api\AbstractApi::patch()
     * @covers \Chaplean\Bundle\RestClientBundle\Api\AbstractApi::delete()
     * @covers \Chaplean\Bundle\RestClientBundle\Api\AbstractApi::addRoute()
     *
     * @return void
     */
    public function testGlobalParametersCalledBeforeRouteDefined()
    {
        $api = new TestApi(new Client(), $this->eventDispatcher);

        $this->assertInstanceOf(Route::class, $api->getGet());
        $this->assertInstanceOf(Route::class, $api->getGet2());
        $this->assertInstanceOf(Route::class, $api->postPost());
        $this->assertInstanceOf(Route::class, $api->putPut());
        $this->assertInstanceOf(Route::class, $api->patchPatch());
        $this->assertInstanceOf(Route::class, $api->deleteDelete());
    }
}
