<?php

namespace App\Responses;

class StateResponse extends SupervisorResponse {

    /**
     * StateResponse constructor
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
        $data = $this->responseValue->value()->scalarval();

        return [
            'statename' => $data['statename']->scalarval(),
            'statecode' => $data['statecode']->scalarval()
        ];
    }
}