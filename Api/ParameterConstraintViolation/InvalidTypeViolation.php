<?php

namespace Chaplean\Bundle\RestClientBundle\Api\ParameterConstraintViolation;

use Chaplean\Bundle\RestClientBundle\Api\ParameterConstraintViolation;

/**
 * Class InvalidTypeViolation.
 *
 * @package   Chaplean\Bundle\RestClientBundle\Exception
 * @author    Matthias - Chaplean <matthias@chaplean.coop>
 * @copyright 2014 - 2016 Chaplean (http://www.chaplean.coop)
 * @since     3.0.0
 */
class InvalidTypeViolation extends ParameterConstraintViolation
{
    /** @var mixed */
    protected $value;

    /** @var string */
    protected $expectedType;

    /**
     * InvalidTypeViolation constructor.
     *
     * @param mixed  $value
     * @param string $expectedType
     */
    public function __construct($value, $expectedType)
    {
        $actualType = is_object($value) ? get_class($value) : gettype($value);

        parent::__construct(sprintf('Expected argument of type "%s", "%s" given', $expectedType, $actualType));
    }

    /**
     * Get value.
     *
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Get expectedType.
     *
     * @return string
     */
    public function getExpectedType()
    {
        return $this->expectedType;
    }
}
