<?php

namespace Tests\Chaplean\Bundle\RestClientBundle\Event;

use Chaplean\Bundle\RestClientBundle\Api\Response\Success\PlainResponse;
use Chaplean\Bundle\RestClientBundle\Event\RequestExecutedEvent;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

/**
 * Class RequestExecutedEventTest.
 *
 * @package   Tests\Chaplean\Bundle\RestClientBundle\Event
 * @author    Matthias - Chaplean <matthias@chaplean.coop>
 * @copyright 2014 - 2017 Chaplean (http://www.chaplean.coop)
 * @since     4.0.0
 */
class RequestExecutedEventTest extends TestCase
{
    /**
     * @covers \Chaplean\Bundle\RestClientBundle\Event\RequestExecutedEvent::__construct()
     * @covers \Chaplean\Bundle\RestClientBundle\Event\RequestExecutedEvent::getResponse()
     *
     * @return void
     */
    public function testConstruct()
    {
        $response = new PlainResponse(new Response(200, [], ''), 'get', 'url', []);
        $event = new RequestExecutedEvent($response);

        $this->assertEquals($response, $event->getResponse());
    }
}
