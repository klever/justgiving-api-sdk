<?php

namespace Klever\JustGivingApiSdk\Clients;

use Klever\JustGivingApiSdk\Clients\Http\HTTPResponse;

class EventApi extends BaseClient
{
    public function Create($event)
    {
        return $this->post("event", $event);
    }

    public function Retrieve($eventId)
    {
        return $this->get("event/" . $eventId);
    }

    public function RetrievePages($eventId, $pageSize = 50, $pageNumber = 1)
    {
        return $this->get("event/" . $eventId . "/pages?PageSize=" . $pageSize . "&PageNum=" . $pageNumber);
    }
}
