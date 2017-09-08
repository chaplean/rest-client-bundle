<?php

namespace Chaplean\Bundle\RestClientBundle\Api\ParameterConstraintViolation;

use Chaplean\Bundle\RestClientBundle\Api\ParameterConstraintViolation;

/**
 * Class NotObjectViolation.
 *
 * @package   Chaplean\Bundle\RestClientBundle\Exception
 * @author    Matthias - Chaplean <matthias@chaplean.coop>
 * @copyright 2014 - 2016 Chaplean (http://www.chaplean.coop)
 * @since     3.0.0
 */
class NotObjectViolation extends ParameterConstraintViolation
{
    /**
     * NotObjectViolation constructor.
     */
    public function __construct()
    {
        parent::__construct('All keys must be strings in an ObjectParameter');
    }
}
