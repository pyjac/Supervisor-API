<?php

namespace Tests\Unit;

use PhpXmlRpc\Value;
use PhpXmlRpc\Response;

use Tests\TestCase;
use App\Responses\ProcessStdoutLogResponse;

class ProcessStdoutLogResponseTest extends TestCase
{
    /**
     * Test the process StdoutLog response success
     *
     * @return void
     */
    public function testProcessStdoutLogResponseSuccess()
    {

        $stdOutLog = 'Some log infomation';
        $value = new Value($stdOutLog);
        $result = new Response($value);
        $processStdoutLogResponse = new ProcessStdoutLogResponse($result);

        $this->assertSame([
            'status' => 'succuss',
            'data' => [
                "stdoutlog" => $stdOutLog
            ]
        ], $processStdoutLogResponse->response());

    }

    /**
     * Test the Process StdoutLog Response Fail
     *
     * @return void
     */
    public function testProcessStdoutLogResponseFail()
    {
        $errorCode = 1;
        $errorMessage = 'Something bad happened';
        $result = new Response(null, $errorCode, $errorMessage);

        $processStdoutLogResponse = new ProcessStdoutLogResponse($result);

        $this->assertSame([
            'status' => 'error',
            'error' => [
                'code' => $errorCode,
                'message' => $errorMessage
            ]
        ], $processStdoutLogResponse->response());

    }

}