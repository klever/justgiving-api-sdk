<?php

namespace Klever\JustGivingApiSdk\Clients\Models;

class ChangePasswordRequest extends Model
{
    public $emailAddress;
    public $newPassword;
    public $currentPassword;
}
