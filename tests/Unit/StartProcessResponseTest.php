<?php

namespace Tests\Unit;

use PhpXmlRpc\Value;
use PhpXmlRpc\Response;

use Tests\TestCase;
use App\Responses\StartProcessResponse;

class StartProcessResponseTest extends TestCase
{
    /**
     * Test the state process response success
     *
     * @return void
     */
    public function testStartProcessResponseSuccess()
    {
        $value = new Value(true, 'boolean');
        $result = new Response($value);

        $startProcessResponse = new StartProcessResponse($result);

        $this->assertSame([
            'status' => 'succuss',
            'data' => [
                'started' => true
            ]
        ], $startProcessResponse->response());
    }

    /**
     * Test the state procsss response fail
     *
     * @return void
     */
    public function testStartProcessResponseFail()
    {
        $errorCode = 1;
        $errorMessage = 'Something bad happened';
        $result = new Response(null, $errorCode, $errorMessage);

        $startProcessResponse = new StartProcessResponse($result);

        $this->assertSame([
            'status' => 'error',
            'error' => [
                'code' => $errorCode,
                'message' => $errorMessage
            ]
        ], $startProcessResponse->response());
    }

}