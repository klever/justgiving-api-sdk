<?php

namespace Konsulting\JustGivingApiSdk\Support\Auth;

class AppAuth implements AuthValue
{
    /**
     * The application ID.
     *
     * @see https://developer.justgiving.com/apidocs/documentation#AppId
     * @var string
     */
    protected $appId;

    public function __construct($appId)
    {
        $this->appId = $appId;
    }

    /**
     * Get the authentication headers.
     *
     * @return array
     */
    public function getHeaders()
    {
        return ['x-api-key' => $this->appId];
    }
}
