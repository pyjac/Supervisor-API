<?php

namespace App\Responses;

class ProcessStdoutLogResponse extends SupervisorResponse {

    /**
     * ProcessStdoutLogResponse constructor
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
            'stdoutlog' => $this->responseValue->value()->scalarval()
        ];
    }
}