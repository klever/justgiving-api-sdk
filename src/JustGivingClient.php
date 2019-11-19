<?php

namespace Konsulting\JustGivingApiSdk;

use GuzzleHttp\ClientInterface;
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
     * JustGivingClient constructor.
     *
     * @param ClientInterface $client
     * @param array           $options
     */
    public function __construct($client, $options = [])
    {
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
        $uri = $this->rootDomain . '/v' . $this->apiVersion . '/' . $uri;

        return $this->httpClient->request($method, $uri, $options);
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
