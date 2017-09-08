<?php

namespace Tests\Chaplean\Bundle\RestClientBundle\Exception;

use Chaplean\Bundle\RestClientBundle\Exception\RequiredParametersOneOfException;
use PHPUnit\Framework\TestCase;

/**
 * Class RequiredParametersOneOfExceptionTest.
 *
 * @package   Tests\Chaplean\Bundle\RestClientBundle\Exception
 * @author    Matthias - Chaplean <matthias@chaplean.coop>
 * @copyright 2014 - 2016 Chaplean (http://www.chaplean.coop)
 * @since     3.0.0
 * @coversDefaultClass
 */
class RequiredParametersOneOfExceptionTest extends TestCase
{
    /**
     * @covers \Chaplean\Bundle\RestClientBundle\Exception\RequiredParametersOneOfException::__construct()
     *
     * @return void
     */
    public function testMessage()
    {
        $violation = new RequiredParametersOneOfException();

        $this->assertEquals(
            'One of required parameters not in original Object',
            $violation->getMessage()
        );
    }
}
