<?php

namespace App\Responses;

abstract class SupervisorResponse {
    
    /**
     * @var \PhpXmlRpc\Value
     */
    protected $responseValue;

    /**
     * SupervisorResponse constructor
     * 
     * @param \PhpXmlRpc\Value $responseValue
     */
    public function __construct($responseValue) {
        $this->responseValue = $responseValue;
    }

    /**
     * Return response data.
     * 
     * @param \PhpXmlRpc\Value $responseValue
     */

    public function response() {
        if ($this->responseValue->faultCode()) {
            return [
                'status' => 'error',
                'error' => [
                    'code' => $this->responseValue->faultCode(), 
                    'message' => $this->responseValue->faultString()
                ]
            ];
        }

        return [
            'status' => 'succuss',
            'data' => $this->data()
        ];
    }

    /**
     * response data
     * 
     * @return array
     */
    abstract protected function data();
}