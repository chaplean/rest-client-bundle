<?php

namespace Chaplean\Bundle\RestClientBundle\Api\ParameterConstraintViolation;

use Chaplean\Bundle\RestClientBundle\Api\ParameterConstraintViolation;

/**
 * Class ExtraDataViolation.
 *
 * @package   Chaplean\Bundle\RestClientBundle\Exception
 * @author    Matthias - Chaplean <matthias@chaplean.coop>
 * @copyright 2014 - 2016 Chaplean (http://www.chaplean.coop)
 * @since     3.0.0
 */
class ExtraDataViolation extends ParameterConstraintViolation
{
    /**
     * @var array
     */
    protected $keys;

    /**
     * ExtraDataViolation constructor.
     *
     * @param string $keys
     */
    public function __construct($keys)
    {
        parent::__construct(sprintf('Extra keys should not be present %s', json_encode($keys)));
    }

    /**
     * Get keys.
     *
     * @return array
     */
    public function getKeys()
    {
        return $this->keys;
    }
}
