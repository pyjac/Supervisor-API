<?php

namespace Tests\Unit;

use PhpXmlRpc\Value;
use PhpXmlRpc\Response;

use Tests\TestCase;
use App\Responses\ApiVersionResponse;

class ApiVersionResponseTest extends TestCase
{
    /**
     * Test the state response success
     *
     * @return void
     */
    public function testApiVersionResponseSuccess()
    {

        $apiVersion = '3.3.0';
        $value = new Value($apiVersion);
        $result = new Response($value);
        $apiVersionResponse = new ApiVersionResponse($result);

        $this->assertSame([
            'status' => 'succuss',
            'data' => [
                "version" => $apiVersion
            ]
        ], $apiVersionResponse->response());

    }

    /**
     * Test the Api Version response fail
     *
     * @return void
     */
    public function testApiVersionResponseFail()
    {
        $errorCode = 1;
        $errorMessage = 'Something bad happened';
        $result = new Response(null, $errorCode, $errorMessage);

        $apiVersionResponse = new ApiVersionResponse($result);

        $this->assertSame([
            'status' => 'error',
            'error' => [
                'code' => $errorCode,
                'message' => $errorMessage
            ]
        ], $apiVersionResponse->response());

    }

}