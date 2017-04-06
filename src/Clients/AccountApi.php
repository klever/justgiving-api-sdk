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
        $url = "account";

        $json = $this->curlWrapper->Get($url);

        return json_decode($json);
    }

    public function CreateV2($createAccountRequest)
    {
        $httpResponse = new HTTPResponse();
        $url = "account";

        $payload = json_encode($createAccountRequest);
        $result = $this->curlWrapper->PutV2($url, $payload);
        $httpResponse->bodyResponse = json_decode($result->bodyResponse);
        $httpResponse->httpStatusCode = $result->httpStatusCode;

        return $httpResponse;
    }

    public function Create($createAccountRequest)
    {
        $url = "account";

        $payload = json_encode($createAccountRequest);
        $json = $this->curlWrapper->Put($url, $payload);

        return json_decode($json);
    }

    public function ListAllPages($email)
    {
        $url = "account/" . $email . "/pages";

        $json = $this->curlWrapper->Get($url);

        return json_decode($json);
    }

    public function IsEmailRegisteredV2($email)
    {
        $httpResponse = new HTTPResponse();
        $url = "account/" . $email;

        $result = $this->curlWrapper->HeadV2($url);
        $httpResponse->bodyResponse = json_decode($result->bodyResponse);
        $httpResponse->httpStatusCode = $result->httpStatusCode;

        return $httpResponse;
    }

    public function IsEmailRegistered($email)
    {
        $url = "account/" . $email;

        $httpInfo = $this->curlWrapper->Head($url);

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
        $url = "account/" . $email . "/requestpasswordreminder";

        $result = $this->curlWrapper->GetV2($url);
        $httpResponse->bodyResponse = json_decode($result->bodyResponse);
        $httpResponse->httpStatusCode = $result->httpStatusCode;

        return $httpResponse;
    }

    public function RequestPasswordReminder($email)
    {
        $url = "account/" . $email . "/requestpasswordreminder";

        $json = $this->curlWrapper->Get($url);

        return json_decode($json);
    }

    public function IsValid($validateAccountRequest)
    {
        $url = "account/validate";

        $payload = json_encode($validateAccountRequest);
        $json = $this->curlWrapper->PostAndGetResponse($url, $payload);

        return json_decode($json);
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
        $url = "account/donations";

        $json = $this->curlWrapper->Get($url);

        return json_decode($json);
    }

    public function AllDonationsByCharity($charityId)
    {
        if ($charityId > 0) {
            $url = "account/donations?charityId=" . $charityId;

            $json = $this->curlWrapper->Get($url);

            return json_decode($json);
        } else {
            return AllDonations();
        }
    }

    public function RatingHistory()
    {
        $url = "account/rating";

        $json = $this->curlWrapper->Get($url);

        return json_decode($json);
    }

    public function RateContent($rateContentRequest)
    {
        $url = "account/rating";

        $payload = json_encode($rateContentRequest);
        $json = $this->curlWrapper->Post($url, $payload);
        if ($json['http_code'] == 201) {
            return true;
        } else if ($json['http_code'] == 401) {
            return false;
        }
    }

    public function ContentFeed()
    {
        $url = "account/feed";

        $json = $this->curlWrapper->Get($url);

        return json_decode($json);
    }

    public function GetInterests()
    {
        $url = "account/interest";

        $json = $this->curlWrapper->Get($url);

        return json_decode($json);
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
        $url = "account/interest";

        $payload = json_encode($replaceInterestRequest);
        $json = $this->curlWrapper->Put($url, $payload, true);
        if ($json['http_code'] == 201) {
            return true;
        } else if ($json['http_code'] == 401) {
            return false;
        }
    }
}
