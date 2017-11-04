<?php

namespace App\Contracts;

interface ISupervisor {

    /**
     * Fetches the supervisor state
     * 
     * @return array
     */
    public function state();

    /**
     * Fetches the supervisor api version
     * 
     * @return array
     */
    public function apiVersion();
}