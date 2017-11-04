<?php

namespace App\Http\Controllers;

use App\Contracts\ISupervisor;
use App\Http\Response\ApiVersionResponse;


class ApiController extends Controller {

    /**
     * @var ISupervisor
     */
    protected $supervisor;

    /**
     * ApiController constructor.
     * 
     * @param ISupervisor $supervisor
     */
    public function __construct(ISupervisor $supervisor)
    {
        $this->supervisor = $supervisor;
    }

     /**
     * Returns thr status of the Supervisor.
     *
     * @return \Illuminate\Http\Response
     */
    public function state()
    {
        return \Response::json($this->supervisor->state());
    }
}