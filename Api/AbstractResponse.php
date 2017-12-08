<?php

namespace Chaplean\Bundle\RestClientBundle\Api;

/**
 * Class AbstractResponse.
 *
 * @package   Chaplean\Bundle\RestClientBundle\Api
 * @author    Valentin - Chaplean <valentin@chaplean.coop>
 * @copyright 2014 - 2017 Chaplean (http://www.chaplean.coop)
 * @since     1.1.0
 */
abstract class AbstractResponse implements ResponseInterface
{
    /**
     * @var string
     */
    private $uuid;

    /**
     * AbstractResponse constructor.
     */
    public function __construct()
    {
        // Create an unique id for each response (use for logging)
        $this->uuid = bin2hex(random_bytes(16));
    }

    /**
     * @return string
     */
    public function getUuid()
    {
        return $this->uuid;
    }
}
