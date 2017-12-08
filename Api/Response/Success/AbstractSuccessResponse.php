<?php

namespace Chaplean\Bundle\RestClientBundle\Api\Response\Success;

use Chaplean\Bundle\RestClientBundle\Api\AbstractResponse;
use Chaplean\Bundle\RestClientBundle\Api\ParameterConstraintViolationCollection;
use GuzzleHttp\Psr7\Response;

/**
 * Class Response.
 *
 * @package   Chaplean\Bundle\RestClientBundle\Api\ParameterConstraintViolation
 * @author    Matthias - Chaplean <matthias@chaplean.coop>
 * @copyright 2014 - 2017 Chaplean (http://www.chaplean.coop)
 * @since     3.0.0
 */
abstract class AbstractSuccessResponse extends AbstractResponse
{
    protected $code;
    protected $headers;
    protected $body;
    protected $method;
    protected $url;
    protected $data;

    /**
     * AbstractResponse constructor.
     *
     * @param Response $response
     * @param string   $method
     * @param string   $url
     * @param array    $data
     */
    public function __construct(Response $response, $method, $url, array $data)
    {
        parent::__construct();

        $this->code = $response->getStatusCode();
        $this->headers = $response->getHeaders();
        $this->body = $response->getBody();
        $this->method = $method;
        $this->url = $url;
        $this->data = $data;
    }

    /**
     * Returns the called url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Returns the called method
     *
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * Returns the data given to Guzzle to perform the request
     *
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Returns the status code returned or 0 if the request failed to execute
     *
     * @return integer
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Wether or not the status code indicates a success request
     *
     * @return boolean
     */
    public function succeeded()
    {
        return $this->code >= 200 && $this->code < 400;
    }

    /**
     * Returns the collection of violations on the validated bound data
     * or null if there's none
     *
     * @return ParameterConstraintViolationCollection|null
     */
    public function getViolations()
    {
        return null;
    }
}
