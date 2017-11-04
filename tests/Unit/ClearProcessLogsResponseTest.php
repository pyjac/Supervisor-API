<?php

namespace Tests\Unit;

use PhpXmlRpc\Value;
use PhpXmlRpc\Response;

use Tests\TestCase;
use App\Responses\ClearProcessLogsResponse;

class ClearProcessLogsResponseTest extends TestCase
{
    /**
     * Test the ClearProcessLogs response success
     *
     * @return void
     */
    public function testClearProcessLogsResponseSuccess()
    {

        $logCleared = true;
        $value = new Value($logCleared, 'boolean');
        $result = new Response($value);
        $clearProcessLogsResponse = new ClearProcessLogsResponse($result);

        $this->assertSame([
            'status' => 'succuss',
            'data' => [
                "log_cleared" => $logCleared
            ]
        ], $clearProcessLogsResponse->response());
    }

    /**
     * Test the ClearProcessLogs response fail
     *
     * @return void
     */
    public function testClearProcessLogsResponseFail()
    {
        $errorCode = 1;
        $errorMessage = 'Something bad happened';
        $result = new Response(null, $errorCode, $errorMessage);

        $clearProcessLogsResponse = new ClearProcessLogsResponse($result);

        $this->assertSame([
            'status' => 'error',
            'error' => [
                'code' => $errorCode,
                'message' => $errorMessage
            ]
        ], $clearProcessLogsResponse->response());

    }

}