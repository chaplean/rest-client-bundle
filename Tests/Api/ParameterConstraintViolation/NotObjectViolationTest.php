<?php

namespace Tests\Chaplean\Bundle\RestClientBundle\Api\ParameterConstraintViolation;

use Chaplean\Bundle\RestClientBundle\Api\ParameterConstraintViolation\NotObjectViolation;
use PHPUnit\Framework\TestCase;

/**
 * Class NotObjectViolationTest.
 *
 * @package   Tests\Chaplean\Bundle\RestClientBundle\Api\ParameterConstraintViolation
 * @author    Matthias - Chaplean <matthias@chaplean.coop>
 * @copyright 2014 - 2017 Chaplean (http://www.chaplean.coop)
 * @since     3.0.0
 */
class NotObjectViolationTest extends TestCase
{
    /**
     * @covers \Chaplean\Bundle\RestClientBundle\Api\ParameterConstraintViolation\NotObjectViolation::__construct()
     *
     * @return void
     */
    public function testMessage()
    {
        $violation = new NotObjectViolation();

        $this->assertEquals(
            'All keys must be strings in an ObjectParameter',
            $violation->getMessage()
        );
    }
}
