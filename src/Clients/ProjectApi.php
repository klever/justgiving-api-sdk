<?php

namespace Klever\JustGivingApiSdk\Clients;

class ProjectApi extends ClientBase
{
    public function GetProject($projectId)
    {
        return $this->get("project/global/" . $projectId);
    }
}
