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
        app()->instance('App\Contracts\ISupervisor', $this->supervisor);
        
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
        app()->instance('App\Contracts\ISupervisor', $this->supervisor);
        
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
        app()->instance('App\Contracts\ISupervisor', $this->supervisor);
        
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
        app()->instance('App\Contracts\ISupervisor', $this->supervisor);
        
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
