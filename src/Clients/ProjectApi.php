<?php

namespace Klever\JustGivingApiSdk\Clients;

class ProjectApi extends ClientBase
{
    public function Projects($searchTerm)
    {
        $url = "project?q=" . $searchTerm;

        $json = $this->getContent($url);

        return json_decode($json);
    }

    public function GetProject($projectId)
    {
        $url = "project/global/" . $projectId;

        $json = $this->getContent($url);

        return json_decode($json);
    }
}
