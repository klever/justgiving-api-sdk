<?php

namespace Klever\JustGivingApiSdk\ResourceClients;

use Klever\JustGivingApiSdk\ResourceClients\Models\EventRequest;

class EventClient extends BaseClient
{
    protected $aliases = [
        'getById'  => 'GetEventById',
        'getTypes' => 'GetEventTypes',
        'getPages' => 'GetPagesForEvent',
        'create'   => 'RegisterEvent',
    ];

    public function getById($eventId)
    {
        return $this->get("event/" . $eventId);
    }

    public function getTypes()
    {
        return $this->get('event/types');
    }

    public function getPages($eventId, $pageSize = 50, $pageNumber = 1)
    {
        return $this->get("event/" . $eventId . "/pages?PageSize=" . $pageSize . "&PageNum=" . $pageNumber);
    }

    public function create(EventRequest $event)
    {
        return $this->post("event", $event);
    }
}
