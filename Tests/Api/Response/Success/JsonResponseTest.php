<?php

namespace Tests\Chaplean\Bundle\RestClientBundle\Api\Response\Success;

use Chaplean\Bundle\RestClientBundle\Api\Response\Success\JsonResponse;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

/**
 * Class JsonResponseTest.
 *
 * @package   Tests\Chaplean\Bundle\RestClientBundle\Api
 * @author    Matthias - Chaplean <matthias@chaplean.coop>
 * @copyright 2014 - 2017 Chaplean (http://www.chaplean.coop)
 * @since     3.0.0
 */
class JsonResponseTest extends TestCase
{
    /**
     * @covers \Chaplean\Bundle\RestClientBundle\Api\Response\Success\JsonResponse::getContent()
     * @covers \Chaplean\Bundle\RestClientBundle\Api\Response\Success\AbstractSuccessResponse::__construct()
     * @covers \Chaplean\Bundle\RestClientBundle\Api\Response\Success\AbstractSuccessResponse::getContent()
     *
     * @return void
     */
    public function testGetContent()
    {
        $body = file_get_contents(__DIR__ . '/../../../Resources/sample_response.json');
        $response = new JsonResponse(new Response(200, [], $body), 'get', 'url', []);

        $this->assertEquals(
            [
                'value1' => [1, 2],
                'value2' => 42,
                'value3' => 'something'
            ],
            $response->getContent()
        );
    }
}
