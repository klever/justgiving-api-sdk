<?php

namespace Klever\JustGivingApiSdk\Clients;

class ProjectApi extends BaseClient
{
    public function GetProject($projectId)
    {
        return $this->get("project/global/" . $projectId);
    }
}
