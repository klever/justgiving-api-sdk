<?php

namespace Klever\JustGivingApiSdk\Clients;

class DonationApi extends BaseClient
{
    public function Retrieve($donationId)
    {
        return $this->get("donation/" . $donationId);
    }

    public function RetrieveStatus($donationId)
    {
        return $this->get("donation/" . $donationId . "/status");
    }

    public function RetrieveDetails($thirdPartReference)
    {
        return $this->get("donation/ref/" . $thirdPartReference);
    }
}
