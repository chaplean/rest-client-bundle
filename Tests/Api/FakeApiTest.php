<?php

namespace Tests\Chaplean\Bundle\RestClientBundle\Api;

use Chaplean\Bundle\RestClientBundle\Api\Route;
use Chaplean\Bundle\RestClientBundle\Tests\Resources\Api\FakeApi;
use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class FakeApiTest.
 *
 * @author    Matthias - Chaplean <matthias@chaplean.coop>
 * @copyright 2014 - 2017 Chaplean (http://www.chaplean.coop)
 * @since     3.0.0
 */
class FakeApiTest extends TestCase
{
    protected $api;

    /**
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->api = new FakeApi(new Client(), new EventDispatcher());
    }

    /**
     * @covers \Chaplean\Bundle\RestClientBundle\Tests\Resources\Api\FakeApi::__construct()
     * @covers \Chaplean\Bundle\RestClientBundle\Tests\Resources\Api\FakeApi::buildApi()
     * @covers \Chaplean\Bundle\RestClientBundle\Api\AbstractApi::__call
     *
     * @return void
     */
    public function testGetBonuses()
    {
        $route = $this->api->getFake_Get_Plain();
        $this->assertInstanceOf('Chaplean\Bundle\RestClientBundle\Api\Route', $route);
        $this->assertEquals('127.0.0.1:80/app_test.php/fake/get.json', $route->getUrl());
        $this->assertEquals(Request::METHOD_GET, $route->getMethod());
    }

    /**
     * @covers \Chaplean\Bundle\RestClientBundle\Tests\Resources\Api\FakeApi::__construct()
     * @covers \Chaplean\Bundle\RestClientBundle\Tests\Resources\Api\FakeApi::buildApi()
     * @covers \Chaplean\Bundle\RestClientBundle\Api\AbstractApi::__call
     *
     * @return void
     */
    public function testPostBonuslyApi()
    {
        $args = array('receiver_email' => 'userbot@chaplean.fr', 'reason' => 'Happy Birthday Test #teamwork', 'amount' => 1);

        /** @var Route $route */
        $route = $this->api->postBonuses()->bindQueryParameters($args);
        $this->assertInstanceOf('Chaplean\Bundle\RestClientBundle\Api\Route', $route);
        $this->assertEquals('127.0.0.1:80/app_test.php/bonuses', $route->getUrl());
        $this->assertEquals(Request::METHOD_POST, $route->getMethod());
    }

    /**
     * @covers \Chaplean\Bundle\RestClientBundle\Tests\Resources\Api\FakeApi::__construct()
     * @covers \Chaplean\Bundle\RestClientBundle\Tests\Resources\Api\FakeApi::buildApi()
     * @covers \Chaplean\Bundle\RestClientBundle\Api\AbstractApi::__call
     *
     * @expectedException \InvalidArgumentException
     * @return void
     */
    public function testGetNonExistingRoute()
    {
        $this->api->getNonExistingRoute();
    }

    /**
     * @covers \Chaplean\Bundle\RestClientBundle\Tests\Resources\Api\FakeApi::__construct()
     * @covers \Chaplean\Bundle\RestClientBundle\Tests\Resources\Api\FakeApi::buildApi()
     * @covers \Chaplean\Bundle\RestClientBundle\Api\AbstractApi::__call
     *
     * @return void
     */
    public function testPostName()
    {
        $route = $this->api->postName();
        $this->assertInstanceOf('Chaplean\Bundle\RestClientBundle\Api\Route', $route);
        $this->assertEquals('127.0.0.1:80/app_test.php/url', $route->getUrl());
        $this->assertEquals(Request::METHOD_POST, $route->getMethod());
    }
}
