<?php

namespace Konsulting\JustGivingApiSdk\Tests;

use Exception;

class TestContext
{
    public $apiUrl = "https://api.staging.justgiving.com/";
    public $apiKey;
    public $apiVersion = 1;
    public $testUsername = "support@justgiving.com";
    public $testValidPassword = "password";
    public $testInvalidPassword = "badPassword";

    /**
     * Pull in the test API key from the test config.
     *
     * @throws Exception
     */
    public function __construct()
    {
        $apiKey = getenv('API_KEY');
        if (! $apiKey) {
            throw new Exception('You must set the environment variable API_KEY.');
        }

        $this->apiKey = $apiKey;
    }
}
