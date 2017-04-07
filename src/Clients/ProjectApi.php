<?php

namespace Klever\JustGivingApiSdk\Clients;

class ProjectApi extends ClientBase
{
    public function Projects($searchTerm)
    {
        return $this->get("project?q=" . $searchTerm);
    }

    public function GetProject($projectId)
    {
        return $this->get("project/global/" . $projectId);
    }
}
