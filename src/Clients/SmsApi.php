<?php

namespace Klever\JustGivingApiSdk\Clients;

class SmsApi extends ClientBase
{


    public function RetrievePageSmsCode($pageShortName)
    {
        $url = "fundraising/pages/" . $pageShortName . "/sms";

        $json = $this->curlWrapper->Get($url);

        return json_decode($json);
    }

    public function UpdatePageSmsCode($pageShortName, $updatePageSmsCodeRequest)
    {
        $requestBody = $updatePageSmsCodeRequest;
        $url = "fundraising/pages/" . $pageShortName . "/sms";
        $payload = json_encode($requestBody);

        $httpInfo = $this->curlWrapper->Put($url, $this->BuildAuthenticationValue(), $payload, true);
        if ($httpInfo['http_code'] == 201) {
            return true;
        } else if ($httpInfo['http_code'] == 404) {
            return false;
        }
    }

    public function CheckSmsCodeAvailability($urn)
    {
        $url = "sms/urn/" . $urn . "/check";

        $httpInfo = $this->curlWrapper->Post($url);
        if ($httpInfo['http_code'] == 200) {
            return true;
        } else if ($httpInfo['http_code'] == 400) {
            return false;
        }
    }
}
