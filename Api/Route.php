<?php

namespace Chaplean\Bundle\RestClientBundle\Api;

use Chaplean\Bundle\RestClientBundle\Event\RequestExecutedEvent;
use Chaplean\Bundle\RestClientBundle\Api\Response\Failure\InvalidParameterResponse;
use Chaplean\Bundle\RestClientBundle\Api\Response\Failure\RequestFailedResponse;
use Chaplean\Bundle\RestClientBundle\Exception\ParameterConstraintValidationFailedException;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\TransferException;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class Route.
 *
 * @package   Chaplean\Bundle\RestClientBundle\Api
 * @author    Matthias - Chaplean <matthias@chaplean.coop>
 * @copyright 2014 - 2017 Chaplean (http://www.chaplean.coop)
 * @since     3.0.0
 */
class Route
{
    protected $client;
    protected $eventDispatcher;

    protected $method;
    protected $url;
    protected $responseType;

    protected $urlParameters;
    protected $queryParameters;
    protected $headers;

    const RESPONSE_BINARY = 'Binary';
    const RESPONSE_PLAIN = 'Plain';
    const RESPONSE_JSON = 'Json';
    const RESPONSE_XML = 'Xml';

    static protected $allowedMethods = [
        Request::METHOD_GET,
        Request::METHOD_POST,
        Request::METHOD_PUT,
        Request::METHOD_PATCH,
        Request::METHOD_DELETE,
    ];

    /**
     * Route constructor.
     *
     * @param string                   $method
     * @param string                   $url
     * @param ClientInterface          $client
     * @param EventDispatcherInterface $eventDispatcher
     * @param GlobalParameters         $globalParameters
     */
    public function __construct($method, $url, ClientInterface $client, EventDispatcherInterface $eventDispatcher, GlobalParameters $globalParameters)
    {
        if (!in_array($method, self::$allowedMethods, true)) {
            throw new \InvalidArgumentException();
        }

        $this->client = $client;
        $this->eventDispatcher = $eventDispatcher;

        $this->method = $method;
        $this->url = $url;
        $this->urlPrefix = $globalParameters->urlPrefix;

        $this->responseType = $globalParameters->responseType;
        $this->urlParameters = $globalParameters->urlParameters;
        $this->queryParameters = $globalParameters->queryParameters;
        $this->headers = $globalParameters->headers;

        $this->bindUrlParameters([]);
        $this->bindQueryParameters([]);
        $this->bindHeaders([]);
    }

    /**
     * Configure the route to expect a binary response (which is the default)
     *
     * @return self
     */
    public function expectsBinary()
    {
        $this->responseType = self::RESPONSE_BINARY;

        return $this;
    }

    /**
     * Configure the route to expect a plain text response (which is the default)
     *
     * @return self
     */
    public function expectsPlain()
    {
        $this->responseType = self::RESPONSE_PLAIN;

        return $this;
    }

    /**
     * Configure the route to expect a json response instead of plain text
     *
     * @return self
     */
    public function expectsJson()
    {
        $this->responseType = self::RESPONSE_JSON;

        return $this;
    }

    /**
     * Configure the route to expect a xml response instead of plain text
     *
     * @return self
     */
    public function expectsXml()
    {
        $this->responseType = self::RESPONSE_XML;

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
     * @param array $parameters
     *
     * @return $this
     */
    public function bindUrlParameters(array $parameters)
    {
        $this->urlParameters->setValue($parameters);

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
     * @param array $parameters
     *
     * @return $this
     */
    public function bindQueryParameters(array $parameters)
    {
        $this->queryParameters->setValue($parameters);

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
     * @param array $parameters
     *
     * @return $this
     */
    public function bindHeaders(array $parameters)
    {
        $this->headers->setValue($parameters);

        return $this;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->urlPrefix . $this->fillInUrlPlaceholders();
    }

    /**
     * @return mixed
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @return ResponseInterface
     */
    public function exec()
    {
        $response = $this->sendRequest();
        $this->eventDispatcher->dispatch('chaplean_rest_client.request_executed', new RequestExecutedEvent($response));

        return $response;
    }

    /**
     * @return ResponseInterface
     */
    private function sendRequest()
    {
        try {
            $url = $this->getUrl();
            $options = $this->buildRequestOptions();
        } catch (ParameterConstraintValidationFailedException $e) {
            return new InvalidParameterResponse($this->getViolations(), $this->method, $this->urlPrefix . '/' . $this->url, []);
        }

        $responseClass = 'Chaplean\Bundle\RestClientBundle\Api\Response\Success\\' . $this->responseType . 'Response';

        try {
            $response = $this->client->request($this->method, $url, $options);

            return new $responseClass($response, $this->method, $url, $options);
        } catch (RequestException $e) {
            $response = $e->getResponse();
            if ($response === null) {
                return new RequestFailedResponse($e, $this->method, $url, $options);
            }

            return new $responseClass($response, $this->method, $url, $options);
        } catch (TransferException $e) {
            return new RequestFailedResponse($e, $this->method, $url, $options);
        }
    }

    /**
     * @return string
     * @throws ParameterConstraintValidationFailedException
     */
    protected function fillInUrlPlaceholders()
    {
        $parts = explode('/', $this->url);

        $parts = array_filter($parts, function($element) {
            return $element !== '';
        });

        $parameters = $this->urlParameters->toArray();

        foreach ($parts as $id => $part) {
            $partsBis = explode('.', $part);
            foreach ($partsBis as $idBis => $partBis) {
                if (strpos($partBis, '{') === 0 && strrpos($partBis, '}') === strlen($partBis) - 1) {
                    $partBis = substr($partBis, 1, -1);
                    $partsBis[$idBis] = $parameters[$partBis];
                }
            }
            $parts[$id] = implode('.', $partsBis);
        }

        return implode('/', $parts);
    }

    /**
     * @return array
     * @throws ParameterConstraintValidationFailedException
     */
    protected function buildRequestOptions()
    {
        return [
            'headers' => $this->headers->toArray(),
            'query'   => $this->queryParameters->toArray(),
        ];
    }

    /**
     * @return ParameterConstraintViolationCollection
     */
    protected function getViolations()
    {
        $violations = new ParameterConstraintViolationCollection();
        $violations->addChild('url', $this->urlParameters->getViolations());
        $violations->addChild('header', $this->headers->getViolations());
        $violations->addChild('query', $this->queryParameters->getViolations());

        return $violations;
    }
}
