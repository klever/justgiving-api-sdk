<?php

namespace Klever\JustGivingApiSdk\Clients;

use Klever\JustGivingApiSdk\Clients\Models\CreateAccountRequest;

class AccountApi extends BaseClient
{
    public function Retrieve()
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

    public function Validate($validateAccountRequest)
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
        return $this->post("account/rating", $rateContentRequest);
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
        return $this->post("account/interest", $addInterestRequest);
    }

    public function ReplaceInterest($replaceInterestRequest)
    {
        return $this->put("account/interest", $replaceInterestRequest);
    }

}
