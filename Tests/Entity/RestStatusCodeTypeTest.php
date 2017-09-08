<?php

namespace Tests\Chaplean\Bundle\RestClientBundle\Entity;

use Chaplean\Bundle\RestClientBundle\Entity\RestLog;
use Chaplean\Bundle\RestClientBundle\Entity\RestStatusCodeType;
use PHPUnit\Framework\TestCase;

/**
 * Class RestStatusCodeTypeTest.
 *
 * @package   Tests\Chaplean\Bundle\RestClientBundle\Entity
 * @author    Matthias - Chaplean <matthias@chaplean.coop>
 * @copyright 2014 - 2017 Chaplean (http://www.chaplean.coop)
 * @since     4.0.0
 */
class RestStatusCodeTypeTest extends TestCase
{
    /**
     * @covers \Chaplean\Bundle\RestClientBundle\Entity\RestStatusCodeType::__construct()
     * @covers \Chaplean\Bundle\RestClientBundle\Entity\RestStatusCodeType::getId()
     * @covers \Chaplean\Bundle\RestClientBundle\Entity\RestStatusCodeType::getCode()
     * @covers \Chaplean\Bundle\RestClientBundle\Entity\RestStatusCodeType::setCode()
     * @covers \Chaplean\Bundle\RestClientBundle\Entity\RestStatusCodeType::getKeyname()
     * @covers \Chaplean\Bundle\RestClientBundle\Entity\RestStatusCodeType::setKeyname()
     * @covers \Chaplean\Bundle\RestClientBundle\Entity\RestStatusCodeType::getLogs()
     * @covers \Chaplean\Bundle\RestClientBundle\Entity\RestStatusCodeType::addLog()
     * @covers \Chaplean\Bundle\RestClientBundle\Entity\RestStatusCodeType::removeLog()
     *
     * @return void
     */
    public function testAccessors()
    {
        $restLog = new RestLog();
        $statusCode = new RestStatusCodeType();

        $statusCode->setCode(418);
        $statusCode->setKeyname('keyname');
        $statusCode->addLog($restLog);

        $this->assertNull($statusCode->getId());
        $this->assertEquals(418, $statusCode->getCode());
        $this->assertEquals('keyname', $statusCode->getKeyname());
        $this->assertCount(1, $statusCode->getLogs());

        $statusCode->removeLog($restLog);

        $this->assertEmpty($statusCode->getLogs());
    }
}
