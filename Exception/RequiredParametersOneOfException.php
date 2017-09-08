<?php

namespace Chaplean\Bundle\RestClientBundle\Exception;

/**
 * Class RequiredParametersOneOfException.
 *
 * @package   Chaplean\Bundle\RestClientBundle\Exception
 * @author    Hugo - Chaplean <hugo@chaplean.coop>
 * @copyright 2014 - 2017 Chaplean (http://www.chaplean.coop)
 * @since     2.0.0
 */
class RequiredParametersOneOfException extends \InvalidArgumentException
{
    /**
     * RequiredParametersOneOfException constructor.
     *
     */
    public function __construct()
    {
        parent::__construct('One of required parameters not in original Object');
    }
}
