<?php

namespace Konsulting\JustGivingApiSdk\Support\Auth;

class BearerAuth implements AuthValue
{
    /** @var string */
    protected $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Get the authentication string.
     *
     * @return string
     */
    public function getAuthString()
    {
        return 'Bearer ' . $this->token;
    }
}
