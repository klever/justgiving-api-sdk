<?php

namespace Klever\JustGivingApiSdk\Clients;

use Exception;
use Klever\JustGivingApiSdk\Clients\Http\HTTPResponse;

class AccountApi extends ClientBase
{
    public function AccountDetailsV2()
    {
        $httpResponse = new HTTPResponse();
        $url = "account";

        $result = $this->curlWrapper->GetV2($url);
        $httpResponse->bodyResponse = json_decode($result->bodyResponse);
        $httpResponse->httpStatusCode = $result->httpStatusCode;

        return $httpResponse;
    }

    public function AccountDetails()
    {
        return $this->get("account");
    }

    public function Create($createAccountRequest)
    {
        return $this->put("account", $createAccountRequest);
    }

    public function ListAllPages($email)
    {
        return $this->get("account/" . $email . "/pages");
    }

    public function IsEmailRegistered($email)
    {
        return $this->head("account/" . $email)->existenceCheck();
    }

    public function RequestPasswordReminder($email)
    {
        return $this->get("account/" . $email . "/requestpasswordreminder");
    }

    public function IsValid($validateAccountRequest)
    {
        return $this->post("account/validate", $validateAccountRequest);
    }

    public function ChangePassword($changePasswordRequest)
    {
        $url = "account/changePassword";

        $payload = json_encode($changePasswordRequest);
        $json = $this->curlWrapper->PostAndGetResponse($url, $payload);

        return json_decode($json);
    }

    public function AllDonations()
    {
        return $this->getContent("account/donations");
    }

    public function AllDonationsByCharity($charityId)
    {
        return $charityId > 0
            ? $this->getContent("account/donations?charityId=" . $charityId)
            : $this->AllDonations();
    }

    public function RatingHistory()
    {
        return $this->getContent("account/rating");
    }

    public function RateContent($rateContentRequest)
    {
        $url = "account/rating";

        $payload = json_encode($rateContentRequest);
        $json = $this->curlWrapper->Post($url, $payload);

        return $json['http_code'] == 201;
    }

    public function ContentFeed()
    {
        return $this->getContent("account/feed");
    }

    public function GetInterests()
    {
        return $this->getContent("account/interest");
    }

    public function AddInterest($addInterestRequest)
    {
        $url = "account/interest";

        $payload = json_encode($addInterestRequest);
        $json = $this->curlWrapper->Post($url, $payload);
        if ($json['http_code'] == 201) {
            return true;
        } else if ($json['http_code'] == 401) {
            return false;
        }
    }

    public function ReplaceInterest($replaceInterestRequest)
    {
        $status = $this->putStatus("account/interest", $replaceInterestRequest);

        return $status == 201;
    }

}
