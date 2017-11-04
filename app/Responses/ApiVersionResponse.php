<?php

namespace App\Responses;

class ApiVersionResponse extends ScalarValueResponse {

    /**
     * Name of scalar value to put in data response
     * 
     * @var string 
     */
    protected $dataValueName = 'version';
}