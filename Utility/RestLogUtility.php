<?php

namespace Chaplean\Bundle\RestClientBundle\Utility;

use Chaplean\Bundle\RestClientBundle\Api\ResponseInterface;
use Chaplean\Bundle\RestClientBundle\Entity\RestLog;
use Chaplean\Bundle\RestClientBundle\Entity\RestMethodType;
use Chaplean\Bundle\RestClientBundle\Entity\RestStatusCodeType;
use Chaplean\Bundle\RestClientBundle\Query\RestLogQuery;
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
    /**
     * @var array
     */
    protected $parameters;

    /**
     * @var RestLogQuery
     */
    protected $restLogQuery;

    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * RestLogUtility constructor.
     *
     * @param array        $parameters
     * @param RestLogQuery $restLogQuery
     * @param Registry     $registry
     *
     * @throws \InvalidArgumentException
     */
    public function __construct(array $parameters, RestLogQuery $restLogQuery, Registry $registry = null)
    {
        $this->parameters = $parameters;
        $this->restLogQuery = $restLogQuery;

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

        /** @var RestMethodType|null $method */
        $method = $this->em->getRepository(RestMethodType::class)->findOneBy(['keyname' => strtolower($methodName)]);
        /** @var RestStatusCodeType|null $statusCode */
        $statusCode = $this->em->getRepository(RestStatusCodeType::class)->findOneBy(['code' => $codeNumber]);

        $restLog = new RestLog();
        $restLog->setUrl($response->getUrl());
        $restLog->setDataSended($response->getData());
        $restLog->setDataReceived($response->getContent());
        $restLog->setDateAdd(new \DateTime());
        $restLog->setResponseUuid($response->getUuid());

        if ($method) {
            $restLog->setMethod($method);
        }

        if ($statusCode) {
            $restLog->setStatusCode($statusCode);
        }

        $this->em->persist($restLog);
        $this->em->flush($restLog);
    }

    /**
     * Persists in database a log entity representing the given $response.
     *
     * @param \DateTime $dateTime
     *
     * @return integer
     */
    public function deleteMostRecentThan(\DateTime $dateTime)
    {
        $restLogDeleted = 0;

        $query = $this->restLogQuery->createFindIdsMostRecentThan($dateTime);
        $idsToRemove = array_map(function($data) {
            return $data['id'];
        }, $query->getResult());

        foreach ($idsToRemove as $id) {
            try {
                $queryRemove = $this->restLogQuery->createDeleteById($id);
                $queryRemove->execute();
                $restLogDeleted ++;
            } catch (\Exception $e){};
        }

        return $restLogDeleted;
    }
}
