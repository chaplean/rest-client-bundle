<?php

namespace Chaplean\Bundle\RestClientBundle\Api;

/**
 * Class ParameterConstraintViolation.
 *
 * @package   Chaplean\Bundle\RestClientBundle\Api
 * @author    Matthias - Chaplean <matthias@chaplean.coop>
 * @copyright 2014 - 2017 Chaplean (http://www.chaplean.coop)
 * @since     3.0.0
 */
class ParameterConstraintViolation extends \InvalidArgumentException implements \JsonSerializable
{
    /**
     * @return string
     */
    public function jsonSerialize()
    {
        return $this->getMessage();
    }
}
