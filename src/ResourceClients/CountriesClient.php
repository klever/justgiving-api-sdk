<?php

namespace Klever\JustGivingApiSdk\ResourceClients;

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
