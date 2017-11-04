<?php

namespace App\Responses;

class StateResponse extends SupervisorResponse {

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