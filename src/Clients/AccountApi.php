<?php

namespace Klever\JustGivingApiSdk\Clients;

use Klever\JustGivingApiSdk\Clients\Models\CreateAccountRequest;

class AccountApi extends BaseClient
{
    protected $aliases = [
        'retrieve'          => 'RetrieveAccount',
        'create'            => 'AccountRegistration',
        'listAllPages'      => 'GetFundraisingPagesForUser',
        'getDonations'   => 'GetDonationsForUser',
        'isEmailRegistered' => 'AccountAvailabilityCheck',
    ];

    public function retrieve()
    {
        return $this->get("account");
    }

    public function create(CreateAccountRequest $createAccountRequest)
    {
        return $this->put("account", $createAccountRequest);
    }

    public function validate($validateAccountRequest)
    {
        return $this->post("account/validate", $validateAccountRequest);
    }

    public function listAllPages($email)
    {
        return $this->get("account/" . $email . "/pages");
    }

    public function getDonations()
    {
        return $this->get("account/donations");
    }

    public function getDonationsByCharity($charityId)
    {
        return $charityId > 0
            ? $this->get("account/donations?charityId=" . $charityId)
            : $this->getDonations();
    }

    public function isEmailRegistered($email)
    {
        return $this->head("account/" . $email)->existenceCheck();
    }

    public function changePassword($changePasswordRequest)
    {
        return $this->post("account/changePassword", $changePasswordRequest);
    }

    public function requestPasswordReminder($email)
    {
        return $this->get("account/" . $email . "/requestpasswordreminder");
    }
}
