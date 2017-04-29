<?php

namespace Klever\JustGivingApiSdk\Support;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
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
    protected $username;

    /** @var string */
    protected $password;

    /** @var string */
    protected $rootDomain;

    /** @var array */
    protected $userOptions;

    /**
     * GuzzleClientFactory constructor.
     *
     * @param string $rootDomain
     * @param string $apiKey
     * @param string $apiVersion
     * @param string $username
     * @param string $password
     * @param array  $options
     */
    public function __construct($rootDomain, $apiKey, $apiVersion, $username = '', $password = '', $options = [])
    {
        $this->rootDomain = $rootDomain;
        $this->apiKey = $apiKey;
        $this->apiVersion = $apiVersion;
        $this->username = $username;
        $this->password = $password;
        $this->userOptions = $options;
    }

    /**
     * Static method for easily creating a client. Requires the same parameters as the class constructor.
     *
     * @param array ...$args
     * @return Client
     */
    public static function build(...$args)
    {
        return (new static(...$args))->createClient();
    }

    /**
     * Set up the handler stack with middleware, configure options and instantiate the Guzzle client.
     *
     * @return Client
     */
    public function createClient()
    {
        $stack = HandlerStack::create();
        $stack->push(Middleware::mapResponse(function(ResponseInterface $response) {
            return new Response($response);
        }));

        return new Client(array_merge([
            'http_errors' => false,
            'handler'     => $stack,
            'base_uri'    => $this->baseUrl(),
            'headers'     => [
                'Accept'        => 'application/json',
                'Authorize'     => 'Basic ' . $this->buildAuthenticationValue(),
                'Authorization' => 'Basic ' . $this->buildAuthenticationValue(),
            ]
        ], $this->userOptions));
    }

    /**
     * Return the base URL string for the API call.
     *
     * @return string
     */
    public function baseUrl()
    {
        return $this->rootDomain . $this->apiKey . '/v' . $this->apiVersion . '/';
    }

    /**
     * Build the base 64 encoded string that contains authentication credentials.
     *
     * @return string
     */
    protected function buildAuthenticationValue()
    {
        return empty($this->username)
            ? ''
            : base64_encode($this->username . ":" . $this->password);
    }
}
