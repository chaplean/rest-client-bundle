<?php

namespace Tests\Chaplean\Bundle\RestClientBundle\Entity;

use Chaplean\Bundle\RestClientBundle\Entity\RestLog;
use Chaplean\Bundle\RestClientBundle\Entity\RestMethodType;
use PHPUnit\Framework\TestCase;

/**
 * Class RestMethodTypeTest.
 *
 * @package   Tests\Chaplean\Bundle\RestClientBundle\Entity
 * @author    Matthias - Chaplean <matthias@chaplean.coop>
 * @copyright 2014 - 2017 Chaplean (http://www.chaplean.coop)
 * @since     4.0.0
 */
class RestMethodTypeTest extends TestCase
{
    /**
     * @covers \Chaplean\Bundle\RestClientBundle\Entity\RestMethodType::__construct()
     * @covers \Chaplean\Bundle\RestClientBundle\Entity\RestMethodType::getId()
     * @covers \Chaplean\Bundle\RestClientBundle\Entity\RestMethodType::getKeyname()
     * @covers \Chaplean\Bundle\RestClientBundle\Entity\RestMethodType::setKeyname()
     * @covers \Chaplean\Bundle\RestClientBundle\Entity\RestMethodType::getLogs()
     * @covers \Chaplean\Bundle\RestClientBundle\Entity\RestMethodType::addLog()
     * @covers \Chaplean\Bundle\RestClientBundle\Entity\RestMethodType::removeLog()
     *
     * @return void
     */
    public function testAccessors()
    {
        $restLog = new RestLog();
        $method = new RestMethodType();

        $method->setKeyname('keyname');
        $method->addLog($restLog);

        $this->assertNull($method->getId());
        $this->assertEquals('keyname', $method->getKeyname());
        $this->assertCount(1, $method->getLogs());

        $method->removeLog($restLog);

        $this->assertEmpty($method->getLogs());
    }
}
