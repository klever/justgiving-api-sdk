<?php

namespace Klever\JustGivingApiSdk\Clients;

use Exception;
use Klever\JustGivingApiSdk\Clients\Http\HTTPResponse;
use Klever\JustGivingApiSdk\Clients\Models\CreateAccountRequest;

class AccountApi extends ClientBase
{
    public function AccountDetailsV2()
    {
        $httpResponse = new HTTPResponse();
        $url = "account";

        $result = $this->httpClient->GetV2($url);
        $httpResponse->bodyResponse = json_decode($result->bodyResponse);
        $httpResponse->httpStatusCode = $result->httpStatusCode;

        return $httpResponse;
    }

    public function AccountDetails()
    {
        return $this->get("account");
    }

    public function Create(CreateAccountRequest $createAccountRequest)
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
        return $this->post("account/changePassword", $changePasswordRequest);
    }

    public function AllDonations()
    {
        return $this->get("account/donations");
    }

    public function AllDonationsByCharity($charityId)
    {
        return $charityId > 0
            ? $this->get("account/donations?charityId=" . $charityId)
            : $this->AllDonations();
    }

    public function RatingHistory()
    {
        return $this->get("account/rating");
    }

    public function RateContent($rateContentRequest)
    {
        $url = "account/rating";

        $payload = json_encode($rateContentRequest);
        $json = $this->httpClient->Post($url, $payload);

        return $json['http_code'] == 201;
    }

    public function ContentFeed()
    {
        return $this->get("account/feed");
    }

    public function GetInterests()
    {
        return $this->get("account/interest");
    }

    public function AddInterest($addInterestRequest)
    {
        $url = "account/interest";

        $payload = json_encode($addInterestRequest);
        $json = $this->httpClient->Post($url, $payload);
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
