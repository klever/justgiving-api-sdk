<?php

namespace Konsulting\JustGivingApiSdk\ResourceClients\Models;

class CreateAccountRequest extends Model
{
    public $reference;
    public $title;
    public $firstName;
    public $lastName;
    public $address;
    public $email;
    public $password;
    public $acceptTermsAndConditions;

    public function __construct($data = null)
    {
        $this->address = new Address();
        parent::__construct($data);
    }
}
