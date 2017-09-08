<?php

namespace Chaplean\Bundle\RestClientBundle\Tests\Resources\Api;

use Chaplean\Bundle\RestClientBundle\Api\AbstractApi;

/**
 * Class WithoutGlobalParametersTestApi.
 *
 * @package   Chaplean\Bundle\RestClientBundle\Tests\Resources
 * @author    Matthias - Chaplean <matthias@chaplean.coop>
 * @copyright 2014 - 2017 Chaplean (http://www.chaplean.coop)
 * @since     3.2.2
 */
class WithoutGlobalParametersTestApi extends AbstractApi
{
    /**
     * @return void
     */
    public function buildApi()
    {
        $this->get('test', 'test');
    }
}
