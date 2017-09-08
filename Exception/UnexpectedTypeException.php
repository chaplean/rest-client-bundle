<?php

namespace Chaplean\Bundle\RestClientBundle\Exception;

/**
 * Class UnexpectedTypeException.
 *
 * @package   Chaplean\Bundle\RestClientBundle\Exception
 * @author    Tom - Chaplean <tom@chaplean.coop>
 * @copyright 2014 - 2016 Chaplean (http://www.chaplean.coop)
 * @since     2.0.0
 */
class UnexpectedTypeException extends \InvalidArgumentException
{
    /**
     * UnexpectedTypeException constructor.
     *
     * @param mixed  $value
     * @param string $expectedType
     */
    public function __construct($value, $expectedType)
    {
        parent::__construct(sprintf('Expected argument of type "%s", "%s" given', $expectedType, is_object($value) ? get_class($value) : gettype($value)));
    }
}
