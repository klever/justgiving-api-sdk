<?php

namespace Klever\JustGivingApiSdk\Clients;

class ProjectApi extends ClientBase
{
    public function Projects($searchTerm)
    {
        $locationFormat = $this->Parent->baseUrl() . "project?q=" . $searchTerm;
        $url = $this->BuildUrl($locationFormat);
        $json = $this->curlWrapper->Get($url);

        return json_decode($json);
    }

    public function GetProject($projectId)
    {
        $locationFormat = $this->Parent->baseUrl() . "project/global/" . $projectId;
        $url = $this->BuildUrl($locationFormat);
        $json = $this->curlWrapper->Get($url);

        return json_decode($json);
    }
}
