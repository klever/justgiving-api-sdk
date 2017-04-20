<?php

namespace Klever\JustGivingApiSdk\Clients;

class CurrencyApi extends BaseClient
{
    public function ValidCurrencies()
    {
        return $this->get("fundraising/currencies");
    }
}
