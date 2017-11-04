<?php

namespace App\Responses;

class ProcessInfoResponse extends SupervisorResponse {
    
    /**
     * The Response data
     * 
     * @return array
     */
    public function data() {
        $result = $this->responseValue->value()->scalarval();
        
        return [
            'description' => $result['description']->scalarval(),
            'pid' => $result['pid']->scalarval(),
            'stderr_logfile' => $result['stderr_logfile']->scalarval(),
            'stop' => $result['stop']->scalarval(),
            'logfile' => $result['logfile']->scalarval(),
            'exitstatus' => $result['exitstatus']->scalarval(),
            'spawnerr' => $result['spawnerr']->scalarval(),
            'now' => $result['now']->scalarval(),
            'group' => $result['group']->scalarval(),
            'name' => $result['name']->scalarval(),
            'statename' => $result['statename']->scalarval(),
            'start' => $result['start']->scalarval(),
            'state' => $result['state']->scalarval(),
            'stdout_logfile' => $result['stdout_logfile']->scalarval() 
        ];
    }
}