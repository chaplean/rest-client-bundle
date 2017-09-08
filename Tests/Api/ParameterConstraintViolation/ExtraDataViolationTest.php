<?php

namespace Tests\Chaplean\Bundle\RestClientBundle\Api\ParameterConstraintViolation;

use Chaplean\Bundle\RestClientBundle\Api\ParameterConstraintViolation\ExtraDataViolation;
use PHPUnit\Framework\TestCase;

/**
 * Class ExtraDataViolationTest.
 *
 * @package   Tests\Chaplean\Bundle\RestClientBundle\Api\ParameterConstraintViolation
 * @author    Matthias - Chaplean <matthias@chaplean.coop>
 * @copyright 2014 - 2017 Chaplean (http://www.chaplean.coop)
 * @since     3.0.0
 */
class ExtraDataViolationTest extends TestCase
{
    /**
     * @covers \Chaplean\Bundle\RestClientBundle\Api\ParameterConstraintViolation\ExtraDataViolation::__construct()
     *
     * @return void
     */
    public function testMessage()
    {
        $violation = new ExtraDataViolation(['1', '2']);

        $this->assertEquals(
            'Extra keys should not be present ["1","2"]',
            $violation->getMessage()
        );
    }
}
