<?php

namespace Konsulting\JustGivingApiSdk\Support\Auth;

class BasicAuth implements AuthValue
{
    /**
     * @param  string  $appId
     * @param  string  $username
     * @param  string  $password
     */
    public function __construct(
        /**
         * The application ID (also known as API key).
         *
         * @see https://developer.justgiving.com/apidocs/documentation#AppId
         */
        protected $appId,
        /**
         * The username of the JustGiving user being authenticated.
         */
        protected $username,
        /**
         * The password of the JustGiving user being authenticated.
         */
        protected $password
    ) {}

    /**
     * Get the authentication headers.
     *
     * @return array
     */
    public function getHeaders()
    {
        return [
            'Authorization' => 'Basic '.base64_encode($this->username.':'.$this->password),
            'x-api-key' => $this->appId,
        ];
    }
}
