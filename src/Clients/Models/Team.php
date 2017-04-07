<?php

namespace Klever\JustGivingApiSdk\Clients\Models;

class TeamMember extends Model
{
    public $pageShortName;
}

class Team extends Model
{
    public $teamShortName;
    public $name;
    public $story;
    public $targetType;
    public $teamType;
    public $target;
    public $teamMembers = [];
}

