<?php

namespace Konsulting\JustGivingApiSdk\Support\Auth;

class BasicAuth implements AuthValue
{
    /** @var string */
    protected $username;

    /** @var string */
    protected $password;

    public function __construct($username, $password)
    {
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * Get the authentication string.
     *
     * @return string
     */
    public function getAuthString()
    {
        return 'Basic ' . base64_encode($this->username . ":" . $this->password);
    }
}
