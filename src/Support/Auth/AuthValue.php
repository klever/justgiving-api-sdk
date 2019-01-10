<?php

namespace Konsulting\JustGivingApiSdk\Support\Auth;

interface AuthValue
{
    /**
     * Get the authentication string.
     *
     * @return string
     */
    public function getAuthString();
}
