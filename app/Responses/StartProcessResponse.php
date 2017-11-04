<?php

namespace App\Responses;

class StartProcessResponse extends SupervisorResponse {

    /**
     * StartProcessResponse constructor
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
            'started' => $this->responseValue->value()->scalarval()
        ];
    }
}