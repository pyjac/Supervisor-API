<?php

namespace App\Responses;

class StartProcessResponse extends ScalarValueResponse {
    
    /**
     * Name of scalar value to put in data response
     * 
     * @var string 
     */
    protected $dataValueName = 'started';
}
