<?php

namespace Chaplean\Bundle\RestClientBundle\Api;

/**
 * Class Constraint.
 *
 * A Constraint is a predicate a value must abide to.
 *
 * @package   Chaplean\Bundle\RestClientBundle\Api
 * @author    Matthias - Chaplean <matthias@chaplean.coop>
 * @copyright 2014 - 2017 Chaplean (http://www.chaplean.coop)
 * @since     3.0.0
 */
abstract class Constraint
{
    /**
     * Run the validation logic and fill the $errors iterator with violations if any
     *
     * @param mixed                                  $value
     * @param ParameterConstraintViolationCollection $errors
     *
     * @return void
     */
    abstract public function validate($value, ParameterConstraintViolationCollection $errors);
}
