<?php

namespace Konsulting\JustGivingApiSdk\Support\Auth;

class NoAuth implements AuthValue
{
    /**
     * Get the authentication string.
     *
     * @return string
     */
    public function getAuthString()
    {
        return '';
    }
}
