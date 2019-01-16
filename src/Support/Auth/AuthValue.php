<?php

namespace Konsulting\JustGivingApiSdk\Support\Auth;

interface AuthValue
{
    /**
     * Get the authentication headers.
     *
     * @return array
     */
    public function getHeaders();
}
