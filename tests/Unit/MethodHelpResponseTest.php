<?php

namespace Tests\Unit;

use PhpXmlRpc\Value;
use PhpXmlRpc\Response;

use Tests\TestCase;
use App\Responses\MethodHelpResponse;

class MethodHelpResponseTest extends TestCase
{
    /**
     * Test that MethodHelp response success
     *
     * @return void
     */
    public function testMethodHelpResponseSuccess()
    {

        $methodHelpTest = 'Some method help text';
        $value = new Value($methodHelpTest);
        $result = new Response($value);
        $methodHelpResponse = new MethodHelpResponse($result);

        $this->assertSame([
            'status' => 'succuss',
            'data' => [
                "method_help" => $methodHelpTest
            ]
        ], $methodHelpResponse->response());

    }

    /**
     * Test  that MethodHelp response fail
     *
     * @return void
     */
    public function testMethodHelpResponseFail()
    {
        $errorCode = 1;
        $errorMessage = 'Something bad happened';
        $result = new Response(null, $errorCode, $errorMessage);

        $methodHelpResponse = new MethodHelpResponse($result);

        $this->assertSame([
            'status' => 'error',
            'error' => [
                'code' => $errorCode,
                'message' => $errorMessage
            ]
        ], $methodHelpResponse->response());

    }

}