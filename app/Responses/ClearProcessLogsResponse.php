<?php

namespace App\Responses;

class ClearProcessLogsResponse extends ScalarValueResponse {
    
    /**
     * Name of scalar value to put in data response
     * 
     * @var string 
     */
    protected $dataValueName = 'log_cleared';
}