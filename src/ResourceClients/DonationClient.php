<?php

namespace Konsulting\JustGivingApiSdk\ResourceClients;

class DonationClient extends BaseClient
{
    protected $aliases = [
        'getById'               => 'RetrieveDonationDetails',
        'getDetailsByReference' => 'RetrieveDonationDetailsByReference',
        'getTotalByReference'   => 'RetrieveDonationTotalByReference',
        'getStatus'             => 'RetrieveDonationStatus',
    ];

    public function getById($donationId)
    {
        return $this->get("donation/" . $donationId);
    }

    public function getStatus($donationId)
    {
        return $this->get("donation/" . $donationId . "/status");
    }

    public function getDetailsByReference($thirdPartyReference)
    {
        return $this->get("donation/ref/" . $thirdPartyReference);
    }

    public function getTotalByReference($thirdPartyReference)
    {
        return $this->get('donationtotal/ref/' . $thirdPartyReference);
    }
}
