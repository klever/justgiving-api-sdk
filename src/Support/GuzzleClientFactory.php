<?php

namespace Konsulting\JustGivingApiSdk\Support;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use Konsulting\JustGivingApiSdk\Support\Auth\AuthValue;
use Konsulting\JustGivingApiSdk\Support\Auth\NoAuth;
use Psr\Http\Message\ResponseInterface;

/**
 * Class GuzzleClientFactory
 *
 * Helper class to instantiate a Guzzle HTTP client with the correct configuration for passing into the JustGiving
 * client.
 */
class GuzzleClientFactory
{
    /** @var string */
    protected $apiKey;

    /** @var string */
    protected $apiVersion;

    /** @var string */
    protected $rootDomain;

    /** @var array */
    protected $userOptions;

    /** @var AuthValue */
    protected $auth;

    /**
     * GuzzleClientFactory constructor.
     *
     * @param string    $rootDomain
     * @param string    $apiKey
     * @param string    $apiVersion
     * @param AuthValue $auth
     * @param array     $options
     */
    public function __construct($rootDomain, $apiKey, $apiVersion, AuthValue $auth = null, $options = [])
    {
        $this->rootDomain = $rootDomain;
        $this->apiKey = $apiKey;
        $this->apiVersion = $apiVersion;
        $this->userOptions = $options;
        $this->auth = $auth ?: new NoAuth;
    }

    /**
     * Set up the handler stack with middleware, configure options and instantiate the Guzzle client.
     *
     * @return Client
     */
    public function createClient()
    {
        $stack = HandlerStack::create();
        $stack->push(Middleware::mapResponse(function (ResponseInterface $response) {
            return new Response($response);
        }));

        return new Client(array_merge([
            'http_errors' => false,
            'handler'     => $stack,
            'base_uri'    => $this->baseUrl(),
            'headers'     => [
                'Accept'        => 'application/json',
                'Authorization' => $this->auth->getAuthString(),
                'x-api-key'     => $this->apiKey,
            ],
        ], $this->userOptions));
    }

    /**
     * Return the base URL string for the API call.
     *
     * @return string
     */
    protected function baseUrl()
    {
        return $this->rootDomain . '/v' . $this->apiVersion . '/';
    }
}
