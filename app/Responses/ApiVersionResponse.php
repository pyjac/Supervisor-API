<?php

namespace App\Responses;

class ApiVersionResponse extends SupervisorResponse {

    /**
     * ApiVersionResponse constructor
     * 
     * @param \PhpXmlRpc\Value $responseValue
     */
    public function __construct($responseValue) {
        parent::__construct($responseValue);
    }

    /**
     * The Response data
     * 
     * @return array
     */
    public function data() {
        return [
            'version' => $this->responseValue->value()->scalarval()
        ];
    }
}