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

    /**
     * The secret key associated with the App ID. Required if JustGiving have set up a secret key for the app.
     *
     * @var string
     */
    protected $secretKey;

    /**
     * AppAuth constructor.
     *
     * @param string $appId
     * @param string $secretKey
     */
    public function __construct($appId, $secretKey = null)
    {
        $this->appId = $appId;
        $this->secretKey = $secretKey;
    }

    /**
     * Get the authentication headers.
     *
     * @return array
     */
    public function getHeaders()
    {
        $headers = ['x-api-key' => $this->appId];

        if ($this->secretKey !== null) {
            $headers['x-application-key'] = $this->secretKey;
        }

        return $headers;
    }
}
