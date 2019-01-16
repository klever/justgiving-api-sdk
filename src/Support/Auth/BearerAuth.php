<?php

namespace Konsulting\JustGivingApiSdk\Support\Auth;

class BearerAuth implements AuthValue
{
    /**
     * The bearer token obtained via oAuth.
     *
     * @see https://justgivingdeveloper.zendesk.com/hc/en-us/articles/207071499-Getting-a-bearer-token
     * @var string
     */
    protected $token;

    /**
     * The oAuth secret provided by JustGiving (this currently has to be requested manually).
     *
     * @see https://justgivingdeveloper.zendesk.com/hc/en-us/articles/115002238925-How-do-I-get-a-secret-key-
     * @var string
     */
    protected $oAuthSecret;

    public function __construct($oAuthSecret, $token)
    {
        $this->token = $token;
        $this->oAuthSecret = $oAuthSecret;
    }

    /**
     * Get the authentication headers.
     *
     * @return array
     */
    public function getHeaders()
    {
        return [
            'Authorization'     => 'Bearer ' . $this->token,
            'x-application-key' => $this->oAuthSecret,
        ];
    }
}
