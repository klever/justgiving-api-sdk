<?php

namespace Klever\JustGivingApiSdk\Clients;

use Klever\JustGivingApiSdk\Clients\Http\HTTPResponse;

class EventApi extends ClientBase
{


    public function Create($event)
    {
        $url = "event";

        $payload = json_encode($event);
        $json = $this->curlWrapper->PostAndGetResponse($url, $payload);

        return json_decode($json);
    }

    public function RetrieveV2($eventId)
    {
        $httpResponse = new HTTPResponse();
        $url = "event/" . $eventId;

        $result = $this->curlWrapper->GetV2($url);
        $httpResponse->bodyResponse = json_decode($result->bodyResponse);
        $httpResponse->httpStatusCode = $result->httpStatusCode;

        return $httpResponse;
    }

    public function Retrieve($eventId)
    {
        $url = "event/" . $eventId;

        $json = $this->getContent($url);

        return json_decode($json);
    }

    public function RetrievePages($eventId, $pageSize = 50, $pageNumber = 1)
    {
        $url = "event/" . $eventId . "/pages?PageSize=" . $pageSize . "&PageNum=" . $pageNumber;

        $json = $this->getContent($url);

        return json_decode($json);
    }
}
