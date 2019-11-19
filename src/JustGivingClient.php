<?php

namespace Konsulting\JustGivingApiSdk;

use GuzzleHttp\Psr7\Request;
use Konsulting\JustGivingApiSdk\Exceptions\ClassNotFoundException;
use Konsulting\JustGivingApiSdk\ResourceClients\AccountClient;
use Konsulting\JustGivingApiSdk\ResourceClients\CampaignClient;
use Konsulting\JustGivingApiSdk\ResourceClients\CharityClient;
use Konsulting\JustGivingApiSdk\ResourceClients\CountriesClient;
use Konsulting\JustGivingApiSdk\ResourceClients\CurrencyClient;
use Konsulting\JustGivingApiSdk\ResourceClients\DonationClient;
use Konsulting\JustGivingApiSdk\ResourceClients\EventClient;
use Konsulting\JustGivingApiSdk\ResourceClients\FundraisingClient;
use Konsulting\JustGivingApiSdk\ResourceClients\LeaderboardClient;
use Konsulting\JustGivingApiSdk\ResourceClients\OneSearchClient;
use Konsulting\JustGivingApiSdk\ResourceClients\ProjectClient;
use Konsulting\JustGivingApiSdk\ResourceClients\SearchClient;
use Konsulting\JustGivingApiSdk\ResourceClients\SmsClient;
use Konsulting\JustGivingApiSdk\ResourceClients\TeamClient;
use Konsulting\JustGivingApiSdk\Support\Auth\AuthValue;
use Konsulting\JustGivingApiSdk\Support\Response;
use Psr\Http\Client\ClientInterface;

/**
 * Class JustGivingClient
 *
 * @property AccountClient     account
 * @property CampaignClient    campaign
 * @property CharityClient     charity
 * @property CountriesClient   countries
 * @property CurrencyClient    currency
 * @property DonationClient    donation
 * @property EventClient       event
 * @property LeaderboardClient leaderboard
 * @property OneSearchClient   oneSearch
 * @property FundraisingClient fundraising
 * @property ProjectClient     project
 * @property SearchClient      search
 * @property SmsClient         sms
 * @property TeamClient        team
 * @property AccountClient     Account
 * @property CampaignClient    Campaign
 * @property CharityClient     Charity
 * @property CountriesClient   Countries
 * @property CurrencyClient    Currency
 * @property DonationClient    Donation
 * @property EventClient       Event
 * @property LeaderboardClient Leaderboard
 * @property ProjectClient     Project
 * @property SearchClient      Search
 * @property SmsClient         Sms
 * @property TeamClient        Team
 */
class JustGivingClient
{
    /**
     * The clients that have been instantiated.
     *
     * @var array
     */
    protected $clients = [];

    /**
     * The client to execute the HTTP requests.
     *
     * @var ClientInterface
     */
    protected $httpClient;

    /**
     * The root domain of the API.
     *
     * @var string
     */
    protected $rootDomain;

    /**
     * The API version to use.
     *
     * @var int
     */
    protected $apiVersion;
    /**
     * @var AuthValue
     */
    private $auth;

    /**
     * JustGivingClient constructor.
     *
     * @param AuthValue       $auth
     * @param ClientInterface $client
     * @param array           $options
     */
    public function __construct(AuthValue $auth, ClientInterface $client, $options = [])
    {
        $this->auth = $auth;
        $this->httpClient = $client;
        $this->rootDomain = $options['root_domain'] ?? 'https://api.justgiving.com';
        $this->apiVersion = $options['api_version'] ?? 1;
    }

    /**
     * Proxy a request onto the HTTP client, using the fully qualified URI.
     *
     * @param string $method
     * @param string $uri
     * @param array  $options
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function request($method, $uri, $options = [])
    {
        $headers = $options['headers'] ?? [];
        $body = $options['body'] ?? null;
        $version = $options['version'] ?? '1.1';

        if (isset($options['json'])) {
            $headers += ['Content-Type' => 'application_json'];
            $body = json_encode($options['json']);
        }

        $request = new Request($method, $this->buildUri($uri), $this->buildHeaders($headers), $body, $version);

        $response = $this->httpClient->sendRequest($request);

        return new Response($response);
    }

    /**
     * Build the full URI using the root URI and API version.
     *
     * @param string $uri
     * @return string
     */
    private function buildUri($uri)
    {
        return $this->rootDomain . '/v' . $this->apiVersion . '/' . $uri;
    }

    /**
     * Merge the per-request headers with the auth headers.
     *
     * @param array $requestHeaders
     * @return array
     */
    private function buildHeaders($requestHeaders)
    {
        $defaultHeaders = ['Accept' => 'application/json'];

        return array_merge($defaultHeaders, $this->auth->getHeaders(), $requestHeaders);
    }

    /**
     * Allow API classes to be called as properties. Return a singleton client class.
     *
     * @param string $property
     * @return mixed
     * @throws \Exception
     */
    public function __get($property)
    {
        $class = __NAMESPACE__ . '\\ResourceClients\\' . ucfirst($property) . 'Client';

        if (! class_exists($class)) {
            throw new ClassNotFoundException($class);
        }

        $this->clients[$class] = isset($this->clients[$class])
            ? $this->clients[$class]
            : new $class($this);

        return $this->clients[$class];
    }
}
