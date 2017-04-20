<?php

namespace Klever\JustGivingApiSdk\Clients;

class CurrencyApi extends BaseClient
{
    protected $aliases = [
        'getValidCodes' => 'GetValidCurrencyCodes',
    ];

    public function getValidCodes()
    {
        return $this->get("fundraising/currencies");
    }
}
