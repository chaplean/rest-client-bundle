<?php

namespace Chaplean\Bundle\RestClientBundle\Api;

/**
 * Class GlobalParameters.
 *
 * @package   Chaplean\Bundle\RestClientBundle\Api
 * @author    Matthias - Chaplean <matthias@chaplean.coop>
 * @copyright 2014 - 2017 Chaplean (http://www.chaplean.coop)
 * @since     3.0.0
 */
class GlobalParameters
{
    public $urlPrefix;

    public $responseType;
    public $requestType;

    public $urlParameters;
    public $queryParameters;
    public $headers;
    public $requestParameters;

    /**
     * GlobalParameters constructor.
     */
    public function __construct()
    {
        $this->urlParameters = Parameter::object([]);
        $this->queryParameters = Parameter::object([]);
        $this->headers = Parameter::object([]);
        $this->requestParameters = Parameter::object([]);

        $this->expectsPlain();
        $this->sendFormUrlEncoded();
    }

    /**
     * Set the url prefix
     *
     * @param string $urlPrefix
     *
     * @return self
     */
    public function urlPrefix($urlPrefix)
    {
        $this->urlPrefix = $urlPrefix;

        return $this;
    }

    /**
     * Configure the route to expect a plain text response (which is the default)
     *
     * @return self
     */
    public function expectsPlain()
    {
        $this->responseType = Route::RESPONSE_PLAIN;

        return $this;
    }

    /**
     * Configure the route to expect a json response instead of plain text
     *
     * @return self
     */
    public function expectsJson()
    {
        $this->responseType = Route::RESPONSE_JSON;

        return $this;
    }

    /**
     * Configure the route to expect a xml response instead of plain text
     *
     * @return self
     */
    public function expectsXml()
    {
        $this->responseType = Route::RESPONSE_XML;

        return $this;
    }

    /**
     * Configure the route to send request data as application/x-www-form-urlencoded
     * (which is the default)
     *
     * @return self
     */
    public function sendFormUrlEncoded()
    {
        $this->requestType = RequestRoute::REQUEST_FORM_URL_ENCODED;

        return $this;
    }

    /**
     * Configure the route to send request data as json
     *
     * @return self
     */
    public function sendJson()
    {
        $this->requestType = RequestRoute::REQUEST_JSON;

        return $this;
    }

    /**
     * Configure the route to send request data as xml
     *
     * @return self
     */
    public function sendXml()
    {
        $this->requestType = RequestRoute::REQUEST_XML;

        return $this;
    }

    /**
     * Configure the route to send request data as a url-encoded key-value pair where the key is JSONString and the
     * value is the request data in json format
     *
     * @return self
     */
    public function sendJSONString()
    {
        $this->requestType = RequestRoute::REQUEST_JSON_STRING;

        return $this;
    }

    /**
     * Set url parameters for this route.
     *
     * @param array $parameters
     *
     * @return $this
     */
    public function urlParameters(array $parameters)
    {
        $this->urlParameters = Parameter::object($parameters);

        return $this;
    }

    /**
     * Set query string parameters for this route.
     *
     * @param array $parameters
     *
     * @return $this
     */
    public function queryParameters(array $parameters)
    {
        $this->queryParameters = Parameter::object($parameters);

        return $this;
    }

    /**
     * Set headers for this route.
     *
     * @param array $parameters
     *
     * @return $this
     */
    public function headers(array $parameters)
    {
        $this->headers = Parameter::object($parameters);

        return $this;
    }

    /**
     * Set request parameters for this route.
     *
     * @param array $parameters
     *
     * @return $this
     */
    public function requestParameters(array $parameters)
    {
        $this->requestParameters = Parameter::Object($parameters);

        return $this;
    }
}
