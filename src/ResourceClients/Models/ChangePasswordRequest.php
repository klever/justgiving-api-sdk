<?php

namespace Konsulting\JustGivingApiSdk\ResourceClients\Models;

class ChangePasswordRequest extends Model
{
    public $emailAddress;
    public $newPassword;
    public $currentPassword;
}
