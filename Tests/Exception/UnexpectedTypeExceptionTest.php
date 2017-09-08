<?php

namespace Tests\Chaplean\Bundle\RestClientBundle\Exception;

use Chaplean\Bundle\RestClientBundle\Exception\UnexpectedTypeException;
use PHPUnit\Framework\TestCase;

/**
 * Class UnexpectedTypeExceptionTest.
 *
 * @package   Tests\Chaplean\Bundle\RestClientBundle\Exception
 * @author    Matthias - Chaplean <matthias@chaplean.coop>
 * @copyright 2014 - 2016 Chaplean (http://www.chaplean.coop)
 * @since     3.0.0
 * @coversDefaultClass Chaplean\Bundle\RestClientBundle\Exception\UnexpectedTypeException
 */
class UnexpectedTypeExceptionTest extends TestCase
{
    /**
     * @covers ::__construct
     *
     * @return void
     */
    public function testMessageWithObject()
    {
        $violation = new UnexpectedTypeException(new \DateTime(), 'integer');

        $this->assertEquals(
            'Expected argument of type "integer", "DateTime" given',
            $violation->getMessage()
        );
    }

    /**
     * @covers ::__construct
     *
     * @return void
     */
    public function testMessageWithPrimitiveValue()
    {
        $violation = new UnexpectedTypeException(42, \DateTime::class);

        $this->assertEquals(
            'Expected argument of type "DateTime", "integer" given',
            $violation->getMessage()
        );
    }
}
