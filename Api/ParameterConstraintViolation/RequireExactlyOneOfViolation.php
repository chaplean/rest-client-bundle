<?php

namespace Chaplean\Bundle\RestClientBundle\Api\ParameterConstraintViolation;

use Chaplean\Bundle\RestClientBundle\Api\ParameterConstraintViolation;

/**
 * Class RequireExactlyOneOfViolation.
 *
 * @package   Chaplean\Bundle\RestClientBundle\Exception
 * @author    Hugo - Chaplean <hugo@chaplean.coop>
 * @copyright 2014 - 2016 Chaplean (http://www.chaplean.coop)
 * @since     3.0.0
 */
class RequireExactlyOneOfViolation extends ParameterConstraintViolation
{
    /**
     * RequireExactlyOneOfViolation constructor.
     */
    public function __construct()
    {
        parent::__construct('No value or more than one entry. Only one value must be entered');
    }
}
