<?php

namespace Klever\JustGivingApiSdk\Clients\Models;

class ChangePasswordRequest extends Model
{
    public $emailaddress;
    public $newpassword;
    public $currentpassword;
}
