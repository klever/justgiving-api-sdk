<?php

namespace Konsulting\JustGivingApiSdk\ResourceClients;

class CurrencyClient extends BaseClient
{
    protected $aliases = [
        'getValidCodes' => 'GetValidCurrencyCodes',
    ];

    public function getValidCodes()
    {
        return $this->get("fundraising/currencies");
    }
}
