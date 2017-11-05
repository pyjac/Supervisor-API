<?php

namespace App\Http\Controllers;

use Validator;
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
     * @param string $name
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function startProcess(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'wait' => 'string|max:255',
        ], [
            'name.required' => 'Process name is required'
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->first();
            return $this->errorResponse($error);
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

    /**
     * Fetches Stdout Log information for the process.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function processStdoutLog(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'offset' => 'required|integer',
            'length' => 'required|integer',
        ], [
            'name.required' => 'Process name is required',
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->first();
            return $this->errorResponse($error);
        }

        $name = $request->query('name');
        $offset = $request->query('offset');
        $length = $request->query('length');
      
        $result = $this->supervisor->processStdoutLog($name, $offset, $length);
        
        return \Response::json($result);
    }

    /**
     * Requests to clear process logs.
     *
     * @param string $name
     * @return \Illuminate\Http\Response
     */
    public function clearProcessLogs(string $name)
    {
        $result = $this->supervisor->clearProcessLogs($name);
        
        return \Response::json($result);
    }

    /**
     * Requests method help.
     *
     * @param string $name
     * @return \Illuminate\Http\Response
     */
    public function methodHelp(string $name)
    {
        $result = $this->supervisor->methodHelp($name);
        
        return \Response::json($result);
    }

    /**
     * Requests method help.
     *
     * @param string $message
     * @return \Illuminate\Http\Response
     */
    private function errorResponse(string $message) {
        return \Response::json([
            'status' => 'error',
            'error' => [
                'message' => $message
            ]
        ]);
    }
}