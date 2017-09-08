<?php

namespace Tests\Chaplean\Bundle\RestClientBundle\Api\ParameterConstraintViolation;

use Chaplean\Bundle\RestClientBundle\Api\ParameterConstraintViolation\RequireAtLeastOneOfViolation;
use PHPUnit\Framework\TestCase;

/**
 * Class RequireAtLeastOneOfViolationTest.
 *
 * @package   Tests\Chaplean\Bundle\RestClientBundle\Api\ParameterConstraintViolation
 * @author    Matthias - Chaplean <matthias@chaplean.coop>
 * @copyright 2014 - 2017 Chaplean (http://www.chaplean.coop)
 * @since     3.0.0
 */
class RequireAtLeastOneOfViolationTest extends TestCase
{
    /**
     * @covers \Chaplean\Bundle\RestClientBundle\Api\ParameterConstraintViolation\RequireAtLeastOneOfViolation::__construct()
     *
     * @return void
     */
    public function testMessage()
    {
        $violation = new RequireAtLeastOneOfViolation();

        $this->assertEquals(
            'No required value was entered',
            $violation->getMessage()
        );
    }
}
