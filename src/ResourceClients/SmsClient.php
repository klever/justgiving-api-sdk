<?php

namespace Konsulting\JustGivingApiSdk\ResourceClients;

class SmsClient extends BaseClient
{
    protected $aliases = [
        'getPageCode'           => 'RetrievePageSmsCode',
        'updatePageCode'        => 'UpdatePageSmsCode',
        'checkCodeAvailability' => 'CheckSmsCodeAvailability',
    ];

    public function getPageCode($pageShortName)
    {
        return $this->get("fundraising/pages/" . $pageShortName . "/sms");
    }

    public function updatePageCode($pageShortName, $updatePageSmsCodeRequest)
    {
        return $this->put("fundraising/pages/" . $pageShortName . "/sms", $updatePageSmsCodeRequest);
    }

    public function checkCodeAvailability($urn)
    {
        return $this->post("sms/urn/" . $urn . "/check");
    }
}
