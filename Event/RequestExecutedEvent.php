<?php

namespace Chaplean\Bundle\RestClientBundle\Event;

use Chaplean\Bundle\RestClientBundle\Api\ResponseInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class RequestExecutedEvent.
 *
 * @package   Chaplean\Bundle\RestClientBundle\Event
 * @author    Matthias - Chaplean <matthias@chaplean.coop>
 * @copyright 2014 - 2017 Chaplean (http://www.chaplean.coop)
 * @since     3.2.2
 */
class RequestExecutedEvent extends Event
{
    /**
     * @var ResponseInterface
     */
    protected $response;

    /**
     * RequestExecutedEvent constructor.
     *
     * @param ResponseInterface $response
     */
    public function __construct(ResponseInterface $response)
    {
        $this->response = $response;
    }

    /**
     * Returns request's response
     *
     * @return ResponseInterface
     */
    public function getResponse()
    {
        return $this->response;
    }
}
