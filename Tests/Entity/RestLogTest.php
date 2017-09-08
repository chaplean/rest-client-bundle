<?php

namespace Tests\Chaplean\Bundle\RestClientBundle\Entity;

use Chaplean\Bundle\RestClientBundle\Entity\RestLog;
use Chaplean\Bundle\RestClientBundle\Entity\RestMethodType;
use Chaplean\Bundle\RestClientBundle\Entity\RestStatusCodeType;
use PHPUnit\Framework\TestCase;

/**
 * Class RestLogTest.
 *
 * @package   Tests\Chaplean\Bundle\RestClientBundle\Entity
 * @author    Matthias - Chaplean <matthias@chaplean.coop>
 * @copyright 2014 - 2017 Chaplean (http://www.chaplean.coop)
 * @since     4.0.0
 */
class RestLogTest extends TestCase
{
    /**
     * @covers \Chaplean\Bundle\RestClientBundle\Entity\RestLog::getId()
     * @covers \Chaplean\Bundle\RestClientBundle\Entity\RestLog::getUrl()
     * @covers \Chaplean\Bundle\RestClientBundle\Entity\RestLog::setUrl()
     * @covers \Chaplean\Bundle\RestClientBundle\Entity\RestLog::getDataSended()
     * @covers \Chaplean\Bundle\RestClientBundle\Entity\RestLog::setDataSended()
     * @covers \Chaplean\Bundle\RestClientBundle\Entity\RestLog::getDataReceived()
     * @covers \Chaplean\Bundle\RestClientBundle\Entity\RestLog::setDataReceived()
     * @covers \Chaplean\Bundle\RestClientBundle\Entity\RestLog::getDateAdd()
     * @covers \Chaplean\Bundle\RestClientBundle\Entity\RestLog::setDateAdd()
     * @covers \Chaplean\Bundle\RestClientBundle\Entity\RestLog::getMethod()
     * @covers \Chaplean\Bundle\RestClientBundle\Entity\RestLog::setMethod()
     * @covers \Chaplean\Bundle\RestClientBundle\Entity\RestLog::getStatusCode()
     * @covers \Chaplean\Bundle\RestClientBundle\Entity\RestLog::setStatusCode()
     *
     * @return void
     */
    public function testAccessors()
    {
        $log = new RestLog();
        $method = new RestMethodType();
        $statusCode = new RestStatusCodeType();

        $log->setUrl('url');
        $log->setDataSended(['data' => 'sended']);
        $log->setDataReceived(['data' => 'received']);
        $log->setDateAdd(new \DateTime('today'));
        $log->setMethod($method);
        $log->setStatusCode($statusCode);

        $this->assertNull($log->getId());
        $this->assertEquals('url', $log->getUrl());
        $this->assertEquals(['data' => 'sended'], $log->getDataSended());
        $this->assertEquals(['data' => 'received'], $log->getDataReceived());
        $this->assertEquals(new \DateTime('today'), $log->getDateAdd());
        $this->assertEquals($method, $log->getMethod());
        $this->assertEquals($statusCode, $log->getStatusCode());
    }
}
