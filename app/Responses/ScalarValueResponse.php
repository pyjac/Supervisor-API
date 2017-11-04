<?php

namespace App\Responses;

class ScalarValueResponse extends SupervisorResponse {
    /**
     * Name of scalar value to put in data response
     * 
     * @var string 
     */
    protected $dataValueName; 

    /**
     * The Response data
     * 
     * @return array
     */
    public function data() {
        return [
            $this->dataValueName => $this->responseValue->value()->scalarval()
        ];
    }
}