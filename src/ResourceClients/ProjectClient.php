<?php

namespace Konsulting\JustGivingApiSdk\ResourceClients;

class ProjectClient extends BaseClient
{
    protected $aliases = [
        'retrieve' => 'GetGlobalProjectById',
    ];

    public function retrieve($projectId)
    {
        return $this->get("project/global/" . $projectId);
    }
}
