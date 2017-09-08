<?php

namespace Chaplean\Bundle\RestClientBundle\Api\ParameterConstraintViolation;

use Chaplean\Bundle\RestClientBundle\Api\ParameterConstraintViolation;

/**
 * Class RequireAtLeastOneOfViolation.
 *
 * @package   Chaplean\Bundle\RestClientBundle\Exception
 * @author    Hugo - Chaplean <hugo@chaplean.coop>
 * @copyright 2014 - 2016 Chaplean (http://www.chaplean.coop)
 * @since     3.0.0
 */
class RequireAtLeastOneOfViolation extends ParameterConstraintViolation
{
    /**
     * RequireAtLeastOneOfViolation constructor.
     */
    public function __construct()
    {
        parent::__construct('No required value was entered');
    }
}
