<?php

namespace Tests\Feature;

use \Mockery as m;
use Tests\TestCase;
use PhpXmlRpc\Value;
use App\Services\Supervisor;


class SupervisorApiTest extends TestCase
{
    /**
     * XML-RPC Client
     * 
     * @var \PhpXmlRpc\Client
     */
    private $client;

    /**
     * Supervisor instance
     * 
     * @var App\Services\Supervisor
     */
    private $supervisor;

    /**
     * Setup test
     * 
     * @return void
     */
    public function setUp() 
    {
        parent::setup();
        $this->client =  m::mock('\PhpXmlRpc\Client');
        $this->supervisor = new Supervisor($this->client);
        app()->instance('App\Contracts\ISupervisor', $this->supervisor);
    }

    /**
     * Test state response with expected result.
     *
     * @return void
     */
    public function testStateTest()
    {
        $value = new Value(
            [
                "statename" => new Value('RUNNING'),
                "statecode" => new Value(1, "int")
            ],
            "struct"
        );
        $this->client->shouldReceive('send')->once()->andReturn(new \PhpXmlRpc\Response($value));
        
        $response = $this->get('/api/state');
        $response->assertJson([
            'status' => 'succuss',
            'data' => [
                "statename" => "RUNNING",
                "statecode" => 1
            ]
        ]);
    }

    /**
     * Test api version response with expected result.
     *
     * @return void
     */
    public function testApiVersionRoute()
    {
        $apiVersion = '3.3.0';
        $value = new Value($apiVersion);
        $this->client->shouldReceive('send')->once()->andReturn(new \PhpXmlRpc\Response($value));
        
        $response = $this->get('/api/api-version');
        $response->assertJson([
            'status' => 'succuss',
            'data' => [
                "version" => $apiVersion
            ]
        ]);
    }

    /**
     * Test process information response with expected result.
     *
     * @return void
     */
    public function testProcessInformationRoute()
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

        $this->client->shouldReceive('send')->once()->andReturn(new \PhpXmlRpc\Response($value));
        
        $response = $this->get('/api/process-info/someprocess');
        $response->assertJson([
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
        ]);
    }

    /**
     * Test start process response with expected result.
     *
     * @return void
     */
    public function testStartProcessRoute()
    {
        $started = true;
        $value = new Value($started, 'boolean');
        $this->client->shouldReceive('send')->once()->andReturn(new \PhpXmlRpc\Response($value));
        
        $response = $this->post('/api/start-process', [
            'name' => 'processname'
        ]);

        $response->assertJson([
            'status' => 'succuss',
            'data' => [
                "started" => $started
            ]
        ]);
    }

    public function testStartProcessWithWaitFalseRoute()
    {
        $started = true;
        $value = new Value($started, 'boolean');
        $this->client->shouldReceive('send')->twice()->andReturn(new \PhpXmlRpc\Response($value));
        
        $response = $this->post('/api/start-process', [
            'name' => 'processname',
            'wait' => 'false'
        ]);
        
        $expectedResponse = [
            'status' => 'succuss',
            'data' => [
                "started" => $started
            ]
        ];
        $response->assertJson($expectedResponse);

        $response = $this->post('/api/start-process', [
            'name' => 'processname',
            'wait' => 'FALSE'
        ]);

        $response->assertJson($expectedResponse);
    }

    public function testStartProcessWithWaitTrueRoute()
    {
        $started = true;
        $value = new Value($started, 'boolean');
        $this->client->shouldReceive('send')->twice()->andReturn(new \PhpXmlRpc\Response($value));
        
        $response = $this->post('/api/start-process', [
            'name' => 'processname',
            'wait' => 'TRUE'
        ]);
        
        $expectedResponse = [
            'status' => 'succuss',
            'data' => [
                "started" => $started
            ]
        ];
        $response->assertJson($expectedResponse);

        $response = $this->post('/api/start-process', [
            'name' => 'processname',
            'wait' => 'true'
        ]);

        $response->assertJson($expectedResponse);
    }

    /**
     * Test start process route fails with expected result.
     *
     * @return void
     */
    public function testStartProcessRouteReturnsErrorWhenProcessNameNotProvided()
    {
        $response = $this->post('/api/start-process', []);
        $response->assertJson([
            'status' => 'error',
            'error' => [
                "message" => 'Process name is required'
            ]
        ]);
    }

    /**
     * Test start process stdoutlog with expected result.
     *
     * @return void
     */
    public function testProcessStdOutLogRoute()
    {
        $stdoutLog = 'some log information';
        $value = new Value($stdoutLog);
        $this->client->shouldReceive('send')->once()->andReturn(new \PhpXmlRpc\Response($value));
        
        $response = $this->get('/api/process-stdout-log?name=processname&length=10&offset=10');
        $response->assertJson([
            'status' => 'succuss',
            'data' => [
                'stdoutlog' => $stdoutLog
            ]
        ]);
    }


    public function testProcessStdOutLogReturnErrorWhenNameNotProvided()
    {
        $response = $this->get('/api/process-stdout-log?length=10&offset=10');
        $response->assertJson([
            'status' => 'error',
            'error' => [
                'message' => 'Process name is required'
            ]
        ]);
    }

    public function testProcessStdOutLogReturnErrorWhenLengthNotProvided()
    {
        $response = $this->get('/api/process-stdout-log?name=som&offset=10');
        $response->assertJson([
            'status' => 'error',
            'error' => [
                'message' => 'The length field is required.'
            ]
        ]);
    }

    public function testProcessStdOutLogReturnErrorWhenOffetNotProvided()
    {
        $response = $this->get('/api/process-stdout-log?name=som&length=10');
        $response->assertJson([
            'status' => 'error',
            'error' => [
                'message' => 'The offset field is required.'
            ]
        ]);
    }

    /**
     * Test process information response with expected result.
     *
     * @return void
     */
    public function testClearProcessLogsRoute()
    {
        $someValue = true;

        $value = new Value($someValue, 'boolean');

        $this->client->shouldReceive('send')->once()->andReturn(new \PhpXmlRpc\Response($value));
        
        $response = $this->get('/api/clear-process-logs/theprogramname');
        $response->assertJson([
            'status' => 'succuss',
            'data' => [
                'log_cleared' => $someValue
            ]
        ]);
    }

    /**
     * Test method help with expected result.
     *
     * @return void
     */
    public function testMethodHelpRoute()
    {
        $someValue = 'some method description';

        $value = new Value($someValue);

        $this->client->shouldReceive('send')->once()->andReturn(new \PhpXmlRpc\Response($value));
        
        $response = $this->get('/api/method-help/somevalidSupervisorMethod');
        $response->assertJson([
            'status' => 'succuss',
            'data' => [
                'method_help' => $someValue
            ]
        ]);
    }

    /**
     * Destruction
     * 
     * @return void
     */
    public function tearDown()
    {
        m::close();
        parent::tearDown();
    }
}
