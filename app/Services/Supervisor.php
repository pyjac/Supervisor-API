<?php

namespace App\Services;

use PhpXmlRpc\Client;
use PhpXmlRpc\Request;
use PhpXmlRpc\Encoder;

use App\Contracts\ISupervisor;
use App\Responses\StateResponse;
use App\Responses\ApiVersionResponse;
use App\Responses\MethodHelpResponse;
use App\Responses\ProcessInfoResponse;
use App\Responses\StartProcessResponse;
use App\Responses\ProcessStdoutLogResponse;
use App\Responses\ClearProcessLogsResponse;


class Supervisor implements ISupervisor {

    protected $supervisorClient;

     /**
     * Fetches the supervisor state
     * 
     * @param \PhpXmlRpc\Client $client
     */
    public function __construct(Client $client) {
        $this->client = $client;
    }

    /**
     * Fetches the supervisor state
     *
     * @return array
     */

    public function state() {
        $result = $this->client->send(new Request('supervisor.getState'));
        $response = new StateResponse($result);

        return $response->response();
    }

    /**
     * Fetches the API version of the supervisor
     * 
     * @return array
     */
    public function apiVersion() {
        $result = $this->client->send(new Request('supervisor.getAPIVersion'));
        $response = new ApiVersionResponse($result);

        return $response->response();
    }

    /**
     * Fetches the process information a managed process name.
     * 
     * @param string $name
     * @return array
     */
    public function processInfo(string $name) {
        $encoder = new Encoder();
        $result = $this->client->send(new Request('supervisor.getProcessInfo', [$encoder->encode($name)]));
        $response = new ProcessInfoResponse($result);

        return $response->response();
    }

    /**
     * Starts the process name.
     * 
     * @param string $name
     * @param bool $wait
     * @return array
     */
    public function startProcess(string $name, $wait) {
        $encoder = new Encoder();
        $result = $this->client->send(new Request('supervisor.startProcess', [
            $encoder->encode($name), $encoder->encode($wait)
        ]));
        $response = new StartProcessResponse($result);

        return $response->response();
    }

    /**
     * Reads Stdout Log.
     * 
     * @param string $name
     * @param bool $offset
     * @param bool $length
     * @return array
     */
    public function processStdoutLog($name, $offset, $length) {
        $encoder = new Encoder();
        $result = $this->client->send(new Request('supervisor.readProcessStdoutLog', [
            $encoder->encode($name), $encoder->encode($offset), $encoder->encode($length)
        ]));
        $response = new ProcessStdoutLogResponse($result);

        return $response->response();
    }

    /**
     * Reads clear process logs.
     * 
     * @param string $name
     * @return array
     */
    public function clearProcessLogs(string $name) {
        $encoder = new Encoder();
        $result = $this->client->send(new Request('supervisor.clearProcessLogs', [
            $encoder->encode($name)
        ]));
        $response = new ClearProcessLogsResponse($result);

        return $response->response();
    }

    /**
     * Gets the method help.
     * 
     * @param string $name
     * @return array
     */
    public function methodHelp(string $name) {
        $encoder = new Encoder();
        
        $result = $this->client->send(new Request('system.methodHelp', [
            $encoder->encode($name)
        ]));

        $response = new MethodHelpResponse($result);

        return $response->response();
    }
}