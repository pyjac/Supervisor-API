<?php

namespace Tests\Unit;

use PhpXmlRpc\Value;
use PhpXmlRpc\Response;

use Tests\TestCase;
use App\Responses\StateResponse;

class StateResponseTest extends TestCase
{
    /**
     * Test the state response success
     *
     * @return void
     */
    public function testStateResponseSuccess()
    {
        $value = new Value(
            [
                "statename" => new Value('RUNNING'),
                "statecode" => new Value(1, "int")
            ],
            "struct"
        );
        $result = new Response($value);

        $stateResponse = new StateResponse($result);

        $this->assertSame([
            'status' => 'succuss',
            'data' => [
                "statename" => "RUNNING",
                "statecode" => 1
            ]
        ], $stateResponse->response());

    }

    /**
     * Test the state response fail
     *
     * @return void
     */
    public function testStateResponseFail()
    {
        $errorCode = 1;
        $errorMessage = 'Something bad happened';
        $result = new Response(null, $errorCode, $errorMessage);

        $stateResponse = new StateResponse($result);

        $this->assertSame([
            'status' => 'error',
            'error' => [
                'code' => $errorCode,
                'message' => $errorMessage
            ]
        ], $stateResponse->response());

    }

}