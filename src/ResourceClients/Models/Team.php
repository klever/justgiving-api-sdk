<?php

namespace Konsulting\JustGivingApiSdk\ResourceClients\Models;

class Team extends Model
{
    public $teamShortName;
    public $name;
    public $story;
    public $targetType;
    public $teamType;
    public $teamTarget;
    public $teamMembers = [];
}

