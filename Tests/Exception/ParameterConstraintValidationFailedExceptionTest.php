<?php

namespace Tests\Chaplean\Bundle\RestClientBundle\Exception;

use Chaplean\Bundle\RestClientBundle\Exception\ParameterConstraintValidationFailedException;
use PHPUnit\Framework\TestCase;

/**
 * Class ParameterConstraintValidationFailedExceptionTest.
 *
 * @package   Tests\Chaplean\Bundle\RestClientBundle\Exception
 * @author    Matthias - Chaplean <matthias@chaplean.coop>
 * @copyright 2014 - 2016 Chaplean (http://www.chaplean.coop)
 * @since     3.0.0
 */
class ParameterConstraintValidationFailedExceptionTest extends TestCase
{
    /**
     * @covers \Chaplean\Bundle\RestClientBundle\Exception\ParameterConstraintValidationFailedException::__construct()
     *
     * @return void
     */
    public function testMessage()
    {
        $violation = new ParameterConstraintValidationFailedException();

        $this->assertEquals(
            '',
            $violation->getMessage()
        );
    }
}
