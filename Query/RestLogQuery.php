<?php

namespace Chaplean\Bundle\RestClientBundle\Query;

use Chaplean\Bundle\RestClientBundle\Entity\RestLog;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * Class RestLogQuery.
 *
 * @package   Chaplean\Bundle\RestClientBundle\Query
 * @author    Hugo - Chaplean <hugo@chaplean.coop>
 * @copyright 2014 - 2018 Chaplean (http://www.chaplean.coop)
 */
class RestLogQuery
{
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * RestLogQuery constructor.
     *
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        $this->em = $registry->getManager();
    }

    /**
     * @param \DateTime $dateTime
     *
     * @return Query
     */
    public function createFindIdsMostRecentThan(\DateTime $dateTime)
    {
        $qb = $this->em->createQueryBuilder();

        return $qb->select('log.id')
            ->from(RestLog::class, 'log')
            ->where('log.dateAdd < :dateLimit')
            ->setParameter('dateLimit', $dateTime->format('Y-m-d'))
            ->getQuery();
    }

    /**
     * @param integer $id
     *
     * @return Query|null
     */
    public function createDeleteById($id)
    {
        $qb = $this->em->createQueryBuilder();

        return $qb->delete(RestLog::class, 'log')
            ->where('log.id = :id')
            ->setParameter('id', $id)
            ->getQuery();
    }
}
