<?php

namespace Tests\Chaplean\Bundle\RestClientBundle\Api;

use Chaplean\Bundle\RestClientBundle\Api\AbstractResponse;
use PHPUnit\Framework\TestCase;

/**
 * Class AbstractResponseTest.
 *
 * @package   Tests\Chaplean\Bundle\RestClientBundle\Api
 * @author    Valentin - Chaplean <valentin@chaplean.coop>
 * @copyright 2014 - 2017 Chaplean (http://www.chaplean.coop)
 * @since     1.1.0
 */
class AbstractResponseTest extends TestCase
{
    /**
     * @covers \Chaplean\Bundle\RestClientBundle\Api\AbstractResponse::__construct()
     * @covers \Chaplean\Bundle\RestClientBundle\Api\AbstractResponse::getUuid()
     *
     * @return void
     */
    public function testGetUuid()
    {
        /** @var AbstractResponse $abstractResponse */
        $abstractResponse = \Mockery::mock(AbstractResponse::class, [])->makePartial();

        $this->assertNotNull($abstractResponse->getUuid());
    }
}
