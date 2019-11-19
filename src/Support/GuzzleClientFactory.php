<?php

namespace Konsulting\JustGivingApiSdk\Support;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use Illuminate\Support\Arr;
use Konsulting\JustGivingApiSdk\Support\Auth\AuthValue;
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
     * @param AuthValue $auth
     * @param array     $options
     */
    public function __construct(AuthValue $auth, $options = [])
    {
        $this->auth = $auth;
        $this->userOptions = $options;
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

        $defaultHeaders = ['Accept' => 'application/json'];

        return new Client(array_merge([
            'http_errors' => false,
            'handler'     => $stack,
            'headers'     => array_merge($defaultHeaders, $this->auth->getHeaders()),
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
