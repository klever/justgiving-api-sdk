<?php

namespace Klever\JustGivingApiSdk\Clients;

class ProjectApi extends BaseClient
{
    protected $aliases = [
        'retrieve' => 'GetGlobalProjectById',
    ];

    public function retrieve($projectId)
    {
        return $this->get("project/global/" . $projectId);
    }
}
