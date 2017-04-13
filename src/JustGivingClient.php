<?php

namespace Klever\JustGivingApiSdk;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use Klever\JustGivingApiSdk\Exceptions\ClassNotFoundException;
use Klever\JustGivingApiSdk\Support\Response;
use Psr\Http\Message\ResponseInterface;

class JustGivingClient
{
    protected $apiKey;
    protected $apiVersion;
    protected $username;
    protected $password;
    protected $rootDomain;

    /**
     * The clients that have been instantiated.
     *
     * @var array
     */
    protected $clients = [];

    /**
     * The client to execute the HTTP requests.
     *
     * @var Client
     */
    protected $httpClient;

    /**
     * JustGivingClient constructor.
     *
     * @param string $rootDomain
     * @param string $apiKey
     * @param string $apiVersion
     * @param string $username
     * @param string $password
     */
    public function __construct($rootDomain, $apiKey, $apiVersion, $username = '', $password = '')
    {
        $this->rootDomain = (string) $rootDomain;
        $this->apiKey = (string) $apiKey;
        $this->apiVersion = (string) $apiVersion;
        $this->username = (string) $username;
        $this->password = (string) $password;

        $stack = HandlerStack::create();
        $stack->push(Middleware::mapResponse(function (ResponseInterface $response) {
            return new Response($response);
        }));

        $this->httpClient = new Client([
            'http_errors' => false,
            'handler'     => $stack,
            'base_uri'    => $this->baseUrl(),
            'headers'     => [
                'Accept'        => 'application/json',
                'Authorize'     => 'Basic ' . $this->BuildAuthenticationValue(),
                'Authorization' => 'Basic ' . $this->BuildAuthenticationValue(),
            ]
        ]);
        $this->debug = false;
    }

    /**
     * Allow API classes to be called as properties, and return a singleton client class.
     *
     * @param string $property
     * @return mixed
     * @throws \Exception
     */
    public function __get($property)
    {
        $class = __NAMESPACE__ . '\\Clients\\' . ucfirst($property) . 'Api';

        if ( ! class_exists($class)) {
            throw new ClassNotFoundException($class);
        }

        $this->clients[$class] = $this->clients[$class] ?? new $class($this->httpClient, $this);

        return $this->clients[$class];
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

    protected function BuildAuthenticationValue()
    {
        return empty($this->username)
            ? ''
            : base64_encode($this->username . ":" . $this->password);
    }
}
