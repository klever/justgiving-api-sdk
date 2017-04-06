<?php

namespace Klever\JustGivingApiSdk\Clients\Models;

class TeamMember
{
    public $pageShortName;
}

class Team
{
    public $teamShortName;
    public $name;
    public $story;
    public $targetType;
    public $teamType;
    public $target;
    public $teamMembers = [];
}

