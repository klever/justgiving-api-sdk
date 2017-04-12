<?php

namespace Klever\JustGivingApiSdk;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use Klever\JustGivingApiSdk\Clients\Http\CurlWrapper;
use Klever\JustGivingApiSdk\Exceptions\ClassNotFoundException;
use Klever\JustGivingApiSdk\Support\Response;
use Psr\Http\Message\ResponseInterface;

class JustGivingClient
{
    protected $ApiKey;
    protected $ApiVersion;
    protected $Username;
    protected $Password;
    protected $RootDomain;

    /**
     * The clients that have been instantiated.
     *
     * @var array
     */
    protected $clients = [];

    /**
     * The client to execute the HTTP requests.
     *
     * @var CurlWrapper
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
        $this->RootDomain = (string) $rootDomain;
        $this->ApiKey = (string) $apiKey;
        $this->ApiVersion = (string) $apiVersion;
        $this->Username = (string) $username;
        $this->Password = (string) $password;

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
        return $this->RootDomain . $this->ApiKey . '/v' . $this->ApiVersion . '/';
    }

    protected function BuildAuthenticationValue()
    {
        return empty($this->Username)
            ? ''
            : base64_encode($this->Username . ":" . $this->Password);
    }
}
