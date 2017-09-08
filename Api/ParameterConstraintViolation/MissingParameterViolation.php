<?php

namespace Chaplean\Bundle\RestClientBundle\Api\ParameterConstraintViolation;

use Chaplean\Bundle\RestClientBundle\Api\ParameterConstraintViolation;

/**
 * Class MissingParameterViolation.
 *
 * @package   Chaplean\Bundle\RestClientBundle\Exception
 * @author    Matthias - Chaplean <matthias@chaplean.coop>
 * @copyright 2014 - 2016 Chaplean (http://www.chaplean.coop)
 * @since     3.0.0
 */
class MissingParameterViolation extends ParameterConstraintViolation
{
    /**
     * MissingParameterViolation constructor.
     *
     * @param string $parameter
     */
    public function __construct($parameter)
    {
        parent::__construct(sprintf('Parameter was not given and is not optional: "%s"', $parameter));
    }
}
