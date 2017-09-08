<?php

namespace Tests\Chaplean\Bundle\RestClientBundle\Api\Response\Success;

use Chaplean\Bundle\RestClientBundle\Api\Response\Success\XmlResponse;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

/**
 * Class XmlResponseTest.
 *
 * @package   Tests\Chaplean\Bundle\RestClientBundle\Api
 * @author    Matthias - Chaplean <matthias@chaplean.coop>
 * @copyright 2014 - 2017 Chaplean (http://www.chaplean.coop)
 * @since     3.0.0
 */
class XmlResponseTest extends TestCase
{
    /**
     * @covers \Chaplean\Bundle\RestClientBundle\Api\Response\Success\XmlResponse::getContent()
     * @covers \Chaplean\Bundle\RestClientBundle\Api\Response\Success\AbstractSuccessResponse::__construct()
     * @covers \Chaplean\Bundle\RestClientBundle\Api\Response\Success\AbstractSuccessResponse::getContent()
     *
     * @return void
     */
    public function testGetContent()
    {
        $body = file_get_contents(__DIR__ . '/../../../Resources/sample_response.xml');
        $response = new XmlResponse(new Response(200, [], $body), 'get', 'url', []);

        $this->assertEquals(
            [
                'value2' => 2,
                'list' => ['element' => [1, 2]],
                '@attributes' => ['attribute' => 'something']
            ],
            $response->getContent()
        );
    }
}
