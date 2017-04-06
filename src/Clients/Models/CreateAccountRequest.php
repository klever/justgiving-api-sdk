<?php

namespace Klever\JustGivingApiSdk\Clients\Models;

class CreateAccountRequest
{
    public $reference;
    public $title;
    public $firstName;
    public $lastName;
    public $address;
    public $email;
    public $password;
    public $acceptTermsAndConditions;

    public function __construct()
    {
        $this->address = new Address();
    }
}
