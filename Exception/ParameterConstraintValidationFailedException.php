<?php

namespace Chaplean\Bundle\RestClientBundle\Exception;

/**
 * Class ParameterConstraintValidationFailedException.
 *
 * @package   Chaplean\Bundle\RestClientBundle\Exception
 * @author    Matthias - Chaplean <matthias@chaplean.coop>
 * @copyright 2014 - 2017 Chaplean (http://www.chaplean.coop)
 * @since     3.0.0
 */
class ParameterConstraintValidationFailedException extends \LogicException
{
    /**
     * ParameterConstraintValidationFailedException constructor.
     */
    public function __construct()
    {
        parent::__construct('');
    }
}
