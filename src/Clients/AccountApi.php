<?php

namespace Klever\JustGivingApiSdk\Clients;

use Exception;
use Klever\JustGivingApiSdk\Clients\Http\HTTPResponse;

class AccountApi extends ClientBase
{
    public function AccountDetailsV2()
    {
        $httpResponse = new HTTPResponse();
        $locationFormat = $this->Parent->baseUrl() . "account";
        $url = $this->BuildUrl($locationFormat);
        $result = $this->curlWrapper->GetV2($url, $this->BuildAuthenticationValue());
        $httpResponse->bodyResponse = json_decode($result->bodyResponse);
        $httpResponse->httpStatusCode = $result->httpStatusCode;

        return $httpResponse;
    }

    public function AccountDetails()
    {
        $locationFormat = $this->Parent->baseUrl() . "account";
        $url = $this->BuildUrl($locationFormat);
        $json = $this->curlWrapper->Get($url, $this->BuildAuthenticationValue());

        return json_decode($json);
    }

    public function CreateV2($createAccountRequest)
    {
        $httpResponse = new HTTPResponse();
        $locationFormat = $this->Parent->baseUrl() . "account";
        $url = $this->BuildUrl($locationFormat);
        $payload = json_encode($createAccountRequest);
        $result = $this->curlWrapper->PutV2($url, $this->BuildAuthenticationValue(), $payload);
        $httpResponse->bodyResponse = json_decode($result->bodyResponse);
        $httpResponse->httpStatusCode = $result->httpStatusCode;

        return $httpResponse;
    }

    public function Create($createAccountRequest)
    {
        $locationFormat = $this->Parent->baseUrl() . "account";
        $url = $this->BuildUrl($locationFormat);
        $payload = json_encode($createAccountRequest);
        $json = $this->curlWrapper->Put($url, $this->BuildAuthenticationValue(), $payload);

        return json_decode($json);
    }

    public function ListAllPages($email)
    {
        $locationFormat = $this->Parent->baseUrl() . "account/" . $email . "/pages";
        $url = $this->BuildUrl($locationFormat);
        $json = $this->curlWrapper->Get($url, $this->BuildAuthenticationValue());

        return json_decode($json);
    }

    public function IsEmailRegisteredV2($email)
    {
        $httpResponse = new HTTPResponse();
        $locationFormat = $this->Parent->baseUrl() . "account/" . $email;
        $url = $this->BuildUrl($locationFormat);
        $result = $this->curlWrapper->HeadV2($url, $this->BuildAuthenticationValue());
        $httpResponse->bodyResponse = json_decode($result->bodyResponse);
        $httpResponse->httpStatusCode = $result->httpStatusCode;

        return $httpResponse;
    }

    public function IsEmailRegistered($email)
    {
        $locationFormat = $this->Parent->baseUrl() . "account/" . $email;
        $url = $this->BuildUrl($locationFormat);
        $httpInfo = $this->curlWrapper->Head($url, $this->BuildAuthenticationValue());

        if ($httpInfo['http_code'] == 200) {
            return true;
        } else if ($httpInfo['http_code'] == 404) {
            return false;
        } else {
            throw new Exception('IsEmailRegistered returned a status code it wasn\'t expecting. Returned ' . $httpInfo['http_code']);
        }
    }

    public function RequestPasswordReminderV2($email)
    {
        $httpResponse = new HTTPResponse();
        $locationFormat = $this->Parent->baseUrl() . "account/" . $email . "/requestpasswordreminder";
        $url = $this->BuildUrl($locationFormat);
        $result = $this->curlWrapper->GetV2($url, $this->BuildAuthenticationValue());
        $httpResponse->bodyResponse = json_decode($result->bodyResponse);
        $httpResponse->httpStatusCode = $result->httpStatusCode;

        return $httpResponse;
    }

    public function RequestPasswordReminder($email)
    {
        $locationFormat = $this->Parent->baseUrl() . "account/" . $email . "/requestpasswordreminder";
        $url = $this->BuildUrl($locationFormat);
        $json = $this->curlWrapper->Get($url, $this->BuildAuthenticationValue());

        return json_decode($json);
    }

    public function IsValid($validateAccountRequest)
    {
        $locationFormat = $this->Parent->baseUrl() . "account/validate";
        $url = $this->BuildUrl($locationFormat);
        $payload = json_encode($validateAccountRequest);
        $json = $this->curlWrapper->PostAndGetResponse($url, $this->BuildAuthenticationValue(), $payload);

        return json_decode($json);
    }

    public function ChangePassword($changePasswordRequest)
    {
        $locationFormat = $this->Parent->baseUrl() . "account/changePassword";
        $url = $this->BuildUrl($locationFormat);
        $payload = json_encode($changePasswordRequest);
        $json = $this->curlWrapper->PostAndGetResponse($url, "", $payload);

        return json_decode($json);
    }

    public function AllDonations()
    {
        $locationFormat = $this->Parent->baseUrl() . "account/donations";
        $url = $this->BuildUrl($locationFormat);
        $json = $this->curlWrapper->Get($url, $this->BuildAuthenticationValue());

        return json_decode($json);
    }

    public function AllDonationsByCharity($charityId)
    {
        if ($charityId > 0) {
            $locationFormat = $this->Parent->baseUrl() . "account/donations?charityId=" . $charityId;
            $url = $this->BuildUrl($locationFormat);
            $json = $this->curlWrapper->Get($url, $this->BuildAuthenticationValue());

            return json_decode($json);
        } else {
            return AllDonations();
        }
    }

    public function RatingHistory()
    {
        $locationFormat = $this->Parent->baseUrl() . "account/rating";
        $url = $this->BuildUrl($locationFormat);
        $json = $this->curlWrapper->Get($url, $this->BuildAuthenticationValue());

        return json_decode($json);
    }

    public function RateContent($rateContentRequest)
    {
        $locationFormat = $this->Parent->baseUrl() . "account/rating";
        $url = $this->BuildUrl($locationFormat);
        $payload = json_encode($rateContentRequest);
        $json = $this->curlWrapper->Post($url, $this->BuildAuthenticationValue(), $payload);
        if ($json['http_code'] == 201) {
            return true;
        } else if ($json['http_code'] == 401) {
            return false;
        }
    }

    public function ContentFeed()
    {
        $locationFormat = $this->Parent->baseUrl() . "account/feed";
        $url = $this->BuildUrl($locationFormat);
        $json = $this->curlWrapper->Get($url, $this->BuildAuthenticationValue());

        return json_decode($json);
    }

    public function GetInterests()
    {
        $locationFormat = $this->Parent->baseUrl() . "account/interest";
        $url = $this->BuildUrl($locationFormat);
        $json = $this->curlWrapper->Get($url, $this->BuildAuthenticationValue());

        return json_decode($json);
    }

    public function AddInterest($addInterestRequest)
    {
        $locationFormat = $this->Parent->baseUrl() . "account/interest";
        $url = $this->BuildUrl($locationFormat);
        $payload = json_encode($addInterestRequest);
        $json = $this->curlWrapper->Post($url, $this->BuildAuthenticationValue(), $payload);
        if ($json['http_code'] == 201) {
            return true;
        } else if ($json['http_code'] == 401) {
            return false;
        }
    }

    public function ReplaceInterest($replaceInterestRequest)
    {
        $locationFormat = $this->Parent->baseUrl() . "account/interest";
        $url = $this->BuildUrl($locationFormat);
        $payload = json_encode($replaceInterestRequest);
        $json = $this->curlWrapper->Put($url, $this->BuildAuthenticationValue(), $payload, true);
        if ($json['http_code'] == 201) {
            return true;
        } else if ($json['http_code'] == 401) {
            return false;
        }
    }
}
