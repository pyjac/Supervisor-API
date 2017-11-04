<?php

namespace App\Http\Controllers;

use \Illuminate\Http\Request;
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

    /**
     * Starts a process on supervisor.
     *
     * @return \Illuminate\Http\Response
     */
    public function startProcess(Request $request)
    {
        if (!$request->has('name')) {

            return \Response::json([
                'status' => 'error',
                'error' => [
                    'message' => 'Process name is required'
                ]
             ]);
        }

        $name = $request->input('name');
        $wait = $request->input('wait', 'TRUE');
        switch($wait) {
            case 'true':
            case 'True':
                $wait = true;
                break;
            case 'false':
            case 'FALSE':
                $wait = false;
                break;
            default:
                $wait = true;
        }
        
        $result = $this->supervisor->startProcess($name, $wait);
        
        return \Response::json($result);
    }
}