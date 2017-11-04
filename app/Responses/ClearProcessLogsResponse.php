<?php

namespace App\Responses;

class ClearProcessLogsResponse extends SupervisorResponse {

    /**
     * ClearProcessLogsResponse constructor
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
            'log_cleared' => $this->responseValue->value()->scalarval()
        ];
    }
}