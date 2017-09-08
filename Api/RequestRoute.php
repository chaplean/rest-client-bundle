<?php

namespace Chaplean\Bundle\RestClientBundle\Api;

use GuzzleHttp\ClientInterface;
use Chaplean\Bundle\RestClientBundle\Exception\ParameterConstraintValidationFailedException;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class RequestRoute.
 *
 * @package   Chaplean\Bundle\RestClientBundle\Api
 * @author    Matthias - Chaplean <matthias@chaplean.coop>
 * @copyright 2014 - 2017 Chaplean (http://www.chaplean.coop)
 * @since     3.0.0
 */
class RequestRoute extends Route
{
    protected $requestType;

    protected $requestParameters;

    const REQUEST_FORM_URL_ENCODED = 'form_params';
    const REQUEST_JSON = 'json';
    const REQUEST_XML = 'xml';
    const REQUEST_JSON_STRING = 'json_string';

    /**
     * RequestRoute constructor.
     *
     * @param string                   $method
     * @param string                   $url
     * @param ClientInterface          $client
     * @param EventDispatcherInterface $eventDispatcher
     * @param GlobalParameters         $globalParameters
     */
    public function __construct($method, $url, ClientInterface $client, EventDispatcherInterface $eventDispatcher, GlobalParameters $globalParameters)
    {
        parent::__construct($method, $url, $client, $eventDispatcher, $globalParameters);

        $this->requestType = $globalParameters->requestType;
        $this->requestParameters = $globalParameters->requestParameters;
    }

    /**
     * Configure the route to send request data as application/x-www-form-urlencoded
     * (which is the default)
     *
     * @return self
     */
    public function sendFormUrlEncoded()
    {
        $this->requestType = self::REQUEST_FORM_URL_ENCODED;

        return $this;
    }

    /**
     * Configure the route to send request data as json
     *
     * @return self
     */
    public function sendJson()
    {
        $this->requestType = self::REQUEST_JSON;

        return $this;
    }

    /**
     * Configure the route to send request data as xml
     *
     * @return self
     */
    public function sendXml()
    {
        $this->requestType = self::REQUEST_XML;

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

    /**
     * @param array $parameters
     *
     * @return $this
     */
    public function bindRequestParameters(array $parameters)
    {
        $this->requestParameters->setValue($parameters);

        return $this;
    }

    /**
     * @return array
     * @throws ParameterConstraintValidationFailedException
     */
    protected function buildRequestOptions()
    {
        return array_merge(
            parent::buildRequestOptions(),
            $this->buildRequestParameters()
        );
    }

    /**
     * @return ParameterConstraintViolationCollection
     */
    protected function getViolations()
    {
        $violations = parent::getViolations();
        $violations->addChild('request', $this->requestParameters->getViolations());

        return $violations;
    }

    /**
     * @return array
     */
    protected function buildRequestParameters()
    {
        $requestType = $this->requestType;
        $requestData = $this->requestParameters->toArray();

        if ($this->requestType === self::REQUEST_JSON_STRING) {
            $requestType = self::REQUEST_FORM_URL_ENCODED;
            $requestData = ['JSONString' => json_encode($requestData)];
        }

        return [$requestType => $requestData];
    }
}
