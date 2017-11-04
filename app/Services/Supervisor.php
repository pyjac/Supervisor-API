<?php

namespace App\Services;

use PhpXmlRpc\Client;
use PhpXmlRpc\Request;
use PhpXmlRpc\Encoder;

use App\Contracts\ISupervisor;
use App\Responses\StateResponse;
use App\Responses\ApiVersionResponse;
use App\Responses\ProcessInfoResponse;


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
     * @return array
     */
    public function processInfo(string $name) {
        $encoder = new Encoder();
        $result = $this->client->send(new Request('supervisor.getProcessInfo', [$encoder->encode($name)]));
        $response = new ProcessInfoResponse($result);

        return $response->response();
    }
}