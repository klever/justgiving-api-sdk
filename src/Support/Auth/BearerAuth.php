<?php

namespace Konsulting\JustGivingApiSdk\Support\Auth;

class BearerAuth implements AuthValue
{
    /**
     * @param  string  $appId
     * @param  string  $token
     * @param  string  $secretKey
     */
    public function __construct(
        /**
         * The application ID (also known as API key).
         *
         * @see https://developer.justgiving.com/apidocs/documentation#AppId
         */
        protected $appId,
        /**
         * The secret key provided by JustGiving (this currently has to be requested manually).
         *
         * @see https://justgivingdeveloper.zendesk.com/hc/en-us/articles/115002238925-How-do-I-get-a-secret-key-
         */
        protected $secretKey,
        /**
         * The bearer token obtained via oAuth.
         *
         * @see https://justgivingdeveloper.zendesk.com/hc/en-us/articles/207071499-Getting-a-bearer-token
         */
        protected $token
    ) {}

    /**
     * Get the authentication headers.
     *
     * @return array
     */
    public function getHeaders()
    {
        return [
            'Authorization' => 'Bearer '.$this->token,
            'x-api-key' => $this->appId,
            'x-application-key' => $this->secretKey,
        ];
    }
}
