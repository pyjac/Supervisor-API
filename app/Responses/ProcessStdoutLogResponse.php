<?php

namespace App\Responses;

class ProcessStdoutLogResponse extends ScalarValueResponse {
    
    /**
     * Name of scalar value to put in data response
     * 
     * @var string 
     */
    protected $dataValueName = 'stdoutlog';
}
