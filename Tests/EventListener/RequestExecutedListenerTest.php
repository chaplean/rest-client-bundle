<?php

namespace Tests\Chaplean\Bundle\RestClientBundle\EventListener;

use Chaplean\Bundle\RestClientBundle\Api\Response\Success\PlainResponse;
use Chaplean\Bundle\RestClientBundle\Event\RequestExecutedEvent;
use Chaplean\Bundle\RestClientBundle\EventListener\RequestExecutedListener;
use Chaplean\Bundle\RestClientBundle\Utility\EmailUtility;
use Chaplean\Bundle\RestClientBundle\Utility\RestLogUtility;
use GuzzleHttp\Psr7\Response;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;

/**
 * Class RequestExecutedListenerTest.
 *
 * @package   Tests\Chaplean\Bundle\RestClientBundle\EventListener
 * @author    Matthias - Chaplean <matthias@chaplean.coop>
 * @copyright 2014 - 2017 Chaplean (http://www.chaplean.coop)
 * @since     3.2.2
 */
class RequestExecutedListenerTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    /**
     * @var RestLogUtility
     */
    protected $restLogUtility;

    /**
     * @var EmailUtility
     */
    protected $emailUtility;

    /**
     * @return void
     */
    public function setUp()
    {
        $this->restLogUtility = \Mockery::mock(RestLogUtility::class);
        $this->emailUtility = \Mockery::mock(EmailUtility::class);
    }

    /**
     * @covers \Chaplean\Bundle\RestClientBundle\EventListener\RequestExecutedListener::__construct()
     * @covers \Chaplean\Bundle\RestClientBundle\EventListener\RequestExecutedListener::getSubscribedEvents()
     * @covers \Chaplean\Bundle\RestClientBundle\EventListener\RequestExecutedListener::onRequestExecuted()
     *
     * @return void
     */
    public function testCallsLoggersOnRequestExecutedEvent()
    {
        $response = new PlainResponse(new Response(500, [], ''), 'get', 'url', []);

        $this->restLogUtility->shouldReceive('logResponse')->with($response);
        $this->emailUtility->shouldReceive('sendRequestExecutedNotificationEmail')->with($response);

        $listener = new RequestExecutedListener($this->restLogUtility, $this->emailUtility);
        $listener->onRequestExecuted(new RequestExecutedEvent($response));
    }
}
