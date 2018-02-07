<?php

namespace Konsulting\JustGivingApiSdk\ResourceClients;

class CountriesClient extends BaseClient
{
    protected $aliases = [
        'countries' => 'ListCountries',
    ];

    public function countries()
    {
        return $this->get("countries");
    }
}
