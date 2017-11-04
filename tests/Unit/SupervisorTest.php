<?php

namespace Tests\Unit;

use \Mockery as m;
use Tests\TestCase;
use PhpXmlRpc\Value;
use App\Services\Supervisor;

class SupervisorTest extends TestCase
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
     * Test the state method
     *
     * @return void
     */
    public function testState()
    {
        $value = new Value(
            [
                "statename" => new Value('RUNNING'),
                "statecode" => new Value(1, "int")
            ],
            "struct"
        );
        $this->client->shouldReceive('send')->once()->andReturn(new \PhpXmlRpc\Response($value));

        $this->assertSame([
            'status' => 'succuss',
            'data' => [
                "statename" => "RUNNING",
                "statecode" => 1
            ]
        ], $this->supervisor->state());
    }
}
