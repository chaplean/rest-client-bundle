<?php

namespace Chaplean\Bundle\RestClientBundle\Utility;

use Chaplean\Bundle\RestClientBundle\Api\ResponseInterface;
use Chaplean\Bundle\RestClientBundle\Entity\RestLog;
use Chaplean\Bundle\RestClientBundle\Entity\RestMethodType;
use Chaplean\Bundle\RestClientBundle\Entity\RestStatusCodeType;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\ORM\EntityManager;

/**
 * Class RestLogUtility.
 *
 * @package   Chaplean\Bundle\RestClientBundle\Utility
 * @author    Matthias - Chaplean <matthias@chaplean.coop>
 * @copyright 2014 - 2017 Chaplean (http://www.chaplean.coop)
 * @since     4.0.0
 */
class RestLogUtility
{
    /** @var array */
    protected $parameters;

    /** @var EntityManager */
    protected $em;

    /**
     * RestLogUtility constructor.
     *
     * @param array    $parameters
     * @param Registry $registry
     */
    public function __construct(array $parameters, Registry $registry = null)
    {
        $this->parameters = $parameters;

        if ($registry === null) {
            if ($this->parameters['enable_database_logging']) {
                throw new \InvalidArgumentException('Database logging is enabled, you must register the doctrine service');
            }
        } else {
            $this->em = $registry->getManager();
        }
    }

    /**
     * Persists in database a log entity representing the given $response.
     *
     * @param ResponseInterface $response
     *
     * @return void
     */
    public function logResponse(ResponseInterface $response)
    {
        if (!$this->parameters['enable_database_logging']) {
            return;
        }

        $methodName = $response->getMethod();
        $codeNumber = $response->getCode();

        $method = $this->em->getRepository(RestMethodType::class)->findOneBy(['keyname' => $methodName]);
        $statusCode = $this->em->getRepository(RestStatusCodeType::class)->findOneBy(['code' => $codeNumber]);

        $restLog = new RestLog();
        $restLog->setUrl($response->getUrl());
        $restLog->setDataSended($response->getData());
        $restLog->setDataReceived($response->getContent());
        $restLog->setDateAdd(new \DateTime());

        if ($method) {
            $restLog->setMethod($method);
        }

        if ($statusCode) {
            $restLog->setStatusCode($statusCode);
        }

        $this->em->persist($restLog);
        $this->em->flush();
    }
}
