<?php

namespace Chaplean\Bundle\RestClientBundle\EventListener;

use Chaplean\Bundle\RestClientBundle\Event\RequestExecutedEvent;
use Chaplean\Bundle\RestClientBundle\Utility\EmailUtility;
use Chaplean\Bundle\RestClientBundle\Utility\RestLogUtility;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class RequestExecutedListenerTest.
 *
 * @package   Chaplean\Bundle\RestClientBundle\EventListener
 * @author    Matthias - Chaplean <matthias@chaplean.coop>
 * @copyright 2014 - 2017 Chaplean (http://www.chaplean.coop)
 * @since     3.2.2
 */
class RequestExecutedListener implements EventSubscriberInterface
{
    /**
     * @var RestLogUtility
     */
    protected $restLogUtility;

    /**
     * @var EmailUtility
     */
    protected $emailUtility;

    /**
     * RequestExecutedListener constructor.
     *
     * @param RestLogUtility $restLogUtility
     * @param EmailUtility   $emailUtility
     */
    public function __construct(RestLogUtility $restLogUtility, EmailUtility $emailUtility)
    {
        $this->restLogUtility = $restLogUtility;
        $this->emailUtility = $emailUtility;
    }

    /**
     * Returns the events to which this class has subscribed.
     *
     * Return format:
     *     array(
     *         array('event' => 'the-event-name', 'method' => 'onEventName', 'class' => 'some-class', 'format' => 'json'),
     *         array(...),
     *     )
     *
     * The class may be omitted if the class wants to subscribe to events of all classes.
     * Same goes for the format key.
     *
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return ['chaplean_rest_client.request_executed' => 'onRequestExecuted'];
    }

    /**
     * Persists in database a log entity representing the request just ran.
     *
     * @param RequestExecutedEvent $event
     *
     * @return void
     */
    public function onRequestExecuted(RequestExecutedEvent $event)
    {
        $response = $event->getResponse();

        $this->restLogUtility->logResponse($response);
        $this->emailUtility->sendRequestExecutedNotificationEmail($response);
    }
}
