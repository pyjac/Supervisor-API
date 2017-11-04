<?php

namespace Tests\Unit;

use PhpXmlRpc\Value;
use PhpXmlRpc\Response;

use Tests\TestCase;
use App\Responses\ProcessInfoResponse;

class ProcessInfoResponseTest extends TestCase
{
    /**
     * Test the process information response success
     *
     * @return void
     */
    public function testProcessInfoResponseSuccess()
    {
        $someValue = 'Some Value';
        $someInt = 1323;

        $value = new Value(
            [
                'description' => new Value($someValue),
                'pid' => new Value($someInt, 'int'),
                'stderr_logfile' => new Value($someValue),
                'stop' => new Value($someInt, 'int'),
                'logfile' => new Value($someValue),
                'exitstatus' => new Value($someInt, 'int'),
                'spawnerr' => new Value($someValue),
                'now' => new Value($someInt, 'int'),
                'group' => new Value($someValue),
                'name' => new Value($someValue),
                'statename' => new Value($someValue),
                'start' => new Value($someInt, 'int'),
                'state' => new Value($someInt, 'int'),
                'stdout_logfile' => new Value($someValue) 
            ],
            "struct"
        );

        $result = new Response($value);
        $ProcessInfoResponse = new ProcessInfoResponse($result);

        $this->assertSame([
            'status' => 'succuss',
            'data' => [
                'description' => $someValue,
                'pid' => $someInt,
                'stderr_logfile' => $someValue,
                'stop' => $someInt,
                'logfile' => $someValue,
                'exitstatus' => $someInt,
                'spawnerr' => $someValue,
                'now' => $someInt,
                'group' => $someValue,
                'name' => $someValue,
                'statename' => $someValue,
                'start' => $someInt,
                'state' => $someInt,
                'stdout_logfile' => $someValue 
            ]
        ], $ProcessInfoResponse->response());

    }

    /**
     * Test the process information fail
     *
     * @return void
     */
    public function testProcessInfoResponseFail()
    {
        $errorCode = 1;
        $errorMessage = 'Something bad happened';
        $result = new Response(null, $errorCode, $errorMessage);

        $processInfoResponse = new ProcessInfoResponse($result);

        $this->assertSame([
            'status' => 'error',
            'error' => [
                'code' => $errorCode,
                'message' => $errorMessage
            ]
        ], $processInfoResponse->response());

    }

}