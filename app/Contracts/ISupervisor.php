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

    /**
     * Fetches the information of the process name
     * 
     * @param string $name
     * @return array
     */
    public function processInfo(string $name);
}