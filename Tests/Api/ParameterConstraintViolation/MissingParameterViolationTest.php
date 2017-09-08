<?php

namespace Tests\Chaplean\Bundle\RestClientBundle\Api\ParameterConstraintViolation;

use Chaplean\Bundle\RestClientBundle\Api\ParameterConstraintViolation\MissingParameterViolation;
use PHPUnit\Framework\TestCase;

/**
 * Class MissingParameterViolationTest.
 *
 * @package   Tests\Chaplean\Bundle\RestClientBundle\Api\ParameterConstraintViolation
 * @author    Matthias - Chaplean <matthias@chaplean.coop>
 * @copyright 2014 - 2017 Chaplean (http://www.chaplean.coop)
 * @since     3.0.0
 */
class MissingParameterViolationTest extends TestCase
{
    /**
     * @covers \Chaplean\Bundle\RestClientBundle\Api\ParameterConstraintViolation\MissingParameterViolation::__construct()
     *
     * @return void
     */
    public function testMessage()
    {
        $violation = new MissingParameterViolation('toto');

        $this->assertEquals(
            'Parameter was not given and is not optional: "toto"',
            $violation->getMessage()
        );
    }
}
