<?php

namespace Tests\Chaplean\Bundle\RestClientBundle\Api\ParameterConstraintViolation;

use Chaplean\Bundle\RestClientBundle\Api\ParameterConstraintViolation\InvalidTypeViolation;
use PHPUnit\Framework\TestCase;

/**
 * Class InvalidTypeViolationTest.
 *
 * @package   Tests\Chaplean\Bundle\RestClientBundle\Api\ParameterConstraintViolation
 * @author    Matthias - Chaplean <matthias@chaplean.coop>
 * @copyright 2014 - 2017 Chaplean (http://www.chaplean.coop)
 * @since     3.0.0
 */
class InvalidTypeViolationTest extends TestCase
{
    /**
     * @covers \Chaplean\Bundle\RestClientBundle\Api\ParameterConstraintViolation\InvalidTypeViolation::__construct()
     *
     * @return void
     */
    public function testMessageWithObject()
    {
        $violation = new InvalidTypeViolation(new \DateTime(), 'integer');

        $this->assertEquals(
            'Expected argument of type "integer", "DateTime" given',
            $violation->getMessage()
        );
    }

    /**
     * @covers \Chaplean\Bundle\RestClientBundle\Api\ParameterConstraintViolation\InvalidTypeViolation::__construct()
     *
     * @return void
     */
    public function testMessageWithPrimitiveValue()
    {
        $violation = new InvalidTypeViolation(42, \DateTime::class);

        $this->assertEquals(
            'Expected argument of type "DateTime", "integer" given',
            $violation->getMessage()
        );
    }
}
