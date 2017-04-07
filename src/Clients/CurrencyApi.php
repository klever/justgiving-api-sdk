<?php

namespace Klever\JustGivingApiSdk\Clients;

class CurrencyApi extends ClientBase
{
    public function ValidCurrencies()
    {
        return $this->get("fundraising/currencies");
    }
}
