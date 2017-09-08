<?php

namespace Chaplean\Bundle\RestClientBundle\Api\ParameterConstraintViolation;

use Chaplean\Bundle\RestClientBundle\Api\ParameterConstraintViolation;

/**
 * Class NotArrayViolation.
 *
 * @package   Chaplean\Bundle\RestClientBundle\Exception
 * @author    Matthias - Chaplean <matthias@chaplean.coop>
 * @copyright 2014 - 2016 Chaplean (http://www.chaplean.coop)
 * @since     3.0.0
 */
class NotArrayViolation extends ParameterConstraintViolation
{
    /**
     * NotArrayViolation constructor.
     */
    public function __construct()
    {
        parent::__construct('All keys must be plain integers in an ArrayParameter');
    }
}
