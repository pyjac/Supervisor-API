<?php

namespace App\Http\Controllers;

use App\Contracts\ISupervisor;
use App\Http\Response\ApiVersionResponse;


class ApiController extends Controller {

    /**
     * @var ISupervisor
     */
    protected $supervisor;

    /**
     * ApiController constructor.
     * 
     * @param ISupervisor $supervisor
     */
    public function __construct(ISupervisor $supervisor)
    {
        $this->supervisor = $supervisor;
    }

     /**
     * Returns thr status of the Supervisor.
     *
     * @return \Illuminate\Http\Response
     */
    public function state()
    {
        return \Response::json($this->supervisor->state());
    }

    /**
     * Returns the api version of the Supervisor
     *
     * @return \Illuminate\Http\Response
     */
    public function apiVersion()
    {
        $result = $this->supervisor->apiVersion();

        return \Response::json($result);
    }

    /**
     * Returns the Process Information of the given process name.
     *
     * @return \Illuminate\Http\Response
     */
    public function processInfo(string $name)
    {
        $result = $this->supervisor->processInfo($name);
        
        return \Response::json($result);
    }
}