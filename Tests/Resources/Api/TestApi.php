<?php

namespace Chaplean\Bundle\RestClientBundle\Tests\Resources\Api;

use Chaplean\Bundle\RestClientBundle\Api\AbstractApi;

/**
 * Class TestApi.
 *
 * @package   Chaplean\Bundle\RestClientBundle\Tests\Resources
 * @author    Matthias - Chaplean <matthias@chaplean.coop>
 * @copyright 2014 - 2017 Chaplean (http://www.chaplean.coop)
 * @since     3.2.2
 */
class TestApi extends AbstractApi
{
    /**
     * @return void
     */
    public function buildApi()
    {
        $this->globalParameters();
        $this->get('get', 'get');
        $this->get('get2', 'get2');
        $this->post('post', 'post');
        $this->put('put', 'put');
        $this->patch('patch', 'patch');
        $this->delete('delete', 'delete');
    }
}
