<?php

namespace Klever\JustGivingApiSdk;

use Klever\JustGivingApiSdk\Clients\Http\CurlWrapper;
use Klever\JustGivingApiSdk\Exceptions\ClassNotFoundException;

class JustGivingClient
{
    public $ApiKey;
    public $ApiVersion;
    public $Username;
    public $Password;
    public $RootDomain;

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
        $this->httpClient = new CurlWrapper($this->baseUrl());
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
}
