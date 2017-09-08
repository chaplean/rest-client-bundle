<?php

namespace Chaplean\Bundle\RestClientBundle\Api\Constraint;

use Chaplean\Bundle\RestClientBundle\Api\Constraint;
use Chaplean\Bundle\RestClientBundle\Api\ParameterConstraintViolationCollection;

/**
 * Class CallbackConstraint.
 *
 * A Constraint with a validation logic taking the form of a single function callback.
 *
 * @package   Chaplean\Bundle\RestClientBundle\Api
 * @author    Matthias - Chaplean <matthias@chaplean.coop>
 * @copyright 2014 - 2015 Chaplean (http://www.chaplean.coop)
 * @since     3.0.0
 */
class CallbackConstraint extends Constraint
{
    protected $validationCallback;

    /**
     * CallbackConstraint constructor.
     *
     * @param callable $validationCallback
     */
    public function __construct(callable $validationCallback)
    {
        $this->validationCallback = $validationCallback;
    }

    /**
     * @param mixed                                  $value
     * @param ParameterConstraintViolationCollection $errors
     *
     * @return mixed
     */
    public function validate($value, ParameterConstraintViolationCollection $errors)
    {
        return ($this->validationCallback)($value, $errors);
    }
}
