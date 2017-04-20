<?php

namespace Klever\JustGivingApiSdk\Clients;

class CountriesApi extends BaseClient
{
    protected $aliases = [
        'countries' => 'ListCountries',
    ];

    public function countries()
    {
        return $this->get("countries");
    }
}
