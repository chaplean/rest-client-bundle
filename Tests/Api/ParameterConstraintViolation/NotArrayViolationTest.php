<?php

namespace Tests\Chaplean\Bundle\RestClientBundle\Api\ParameterConstraintViolation;

use Chaplean\Bundle\RestClientBundle\Api\ParameterConstraintViolation\NotArrayViolation;
use PHPUnit\Framework\TestCase;

/**
 * Class NotArrayViolationTest.
 *
 * @package   Tests\Chaplean\Bundle\RestClientBundle\Api\ParameterConstraintViolation
 * @author    Matthias - Chaplean <matthias@chaplean.coop>
 * @copyright 2014 - 2017 Chaplean (http://www.chaplean.coop)
 * @since     3.0.0
 */
class NotArrayViolationTest extends TestCase
{
    /**
     * @covers \Chaplean\Bundle\RestClientBundle\Api\ParameterConstraintViolation\NotArrayViolation::__construct()
     *
     * @return void
     */
    public function testMessage()
    {
        $violation = new NotArrayViolation();

        $this->assertEquals(
            'All keys must be plain integers in an ArrayParameter',
            $violation->getMessage()
        );
    }
}
