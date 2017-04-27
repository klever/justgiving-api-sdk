<?php

namespace Klever\JustGivingApiSdk\ResourceClients\Models;

class EventRequest extends Model
{
    public $name;
    public $description;
    public $completionDate;
    public $expiryDate;
    public $startDate;
    public $eventType;
    public $location;
    public $charityId;
}
