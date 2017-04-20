<?php

namespace Klever\JustGivingApiSdk\Clients\Models;

class Team extends Model
{
    public $teamShortName;
    public $name;
    public $story;
    public $targetType;
    public $teamType;
    public $arget;
    public $teamMembers = [];
}

