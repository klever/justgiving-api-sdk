<?php

namespace Konsulting\JustGivingApiSdk\Support\Auth;

class BasicAuth implements AuthValue
{
    /**
     * The application ID (also known as API key).
     *
     * @see https://developer.justgiving.com/apidocs/documentation#AppId
     * @var string
     */
    protected $appId;

    /**
     * The username of the JustGiving user being authenticated.
     *
     * @var string
     */
    protected $username;

    /**
     * The password of the JustGiving user being authenticated.
     *
     * @var string
     */
    protected $password;

    public function __construct($appId, $username, $password)
    {
        $this->username = $username;
        $this->password = $password;
        $this->appId = $appId;
    }

    /**
     * Get the authentication headers.
     *
     * @return array
     */
    public function getHeaders()
    {
        return [
            'Authorization' => 'Basic ' . base64_encode($this->username . ":" . $this->password),
            'x-api-key'     => $this->appId,
        ];
    }
}
