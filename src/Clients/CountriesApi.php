<?php

namespace Klever\JustGivingApiSdk\Clients;

class CountriesApi extends ClientBase
{
    public function Countries()
    {
        return $this->get("countries");
    }
}
