<?php

namespace Tests\Chaplean\Bundle\RestClientBundle\Exception;

use Chaplean\Bundle\RestClientBundle\Exception\LogicException;
use PHPUnit\Framework\TestCase;

/**
 * Class LogicExceptionTest.
 *
 * @package   Tests\Chaplean\Bundle\RestClientBundle\Exception
 * @author    Tom - Chaplean <tom@chaplean.coop>
 * @copyright 2014 - 2016 Chaplean (http://www.chaplean.coop)
 * @since     2.0.0
 */
class LogicExceptionTest extends TestCase
{
    /**
     * @return void
     */
    public function testExceptionInstance()
    {
        $exception = new LogicException();

        $this->assertInstanceOf('Exception', $exception);
    }
}
