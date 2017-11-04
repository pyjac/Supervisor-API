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
