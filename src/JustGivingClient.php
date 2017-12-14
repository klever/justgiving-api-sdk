<?php

namespace Klever\JustGivingApiSdk;

use GuzzleHttp\ClientInterface;
use Klever\JustGivingApiSdk\Exceptions\ClassNotFoundException;
use Klever\JustGivingApiSdk\ResourceClients\AccountClient;
use Klever\JustGivingApiSdk\ResourceClients\CampaignClient;
use Klever\JustGivingApiSdk\ResourceClients\CharityClient;
use Klever\JustGivingApiSdk\ResourceClients\CountriesClient;
use Klever\JustGivingApiSdk\ResourceClients\CurrencyClient;
use Klever\JustGivingApiSdk\ResourceClients\DonationClient;
use Klever\JustGivingApiSdk\ResourceClients\EventClient;
use Klever\JustGivingApiSdk\ResourceClients\FundraisingClient;
use Klever\JustGivingApiSdk\ResourceClients\LeaderboardClient;
use Klever\JustGivingApiSdk\ResourceClients\OneSearchClient;
use Klever\JustGivingApiSdk\ResourceClients\ProjectClient;
use Klever\JustGivingApiSdk\ResourceClients\SearchClient;
use Klever\JustGivingApiSdk\ResourceClients\SmsClient;
use Klever\JustGivingApiSdk\ResourceClients\TeamClient;

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
     * JustGivingClient constructor.
     *
     * @param ClientInterface $client
     */
    public function __construct($client)
    {
        $this->httpClient = $client;
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

        if ( ! class_exists($class)) {
            throw new ClassNotFoundException($class);
        }

        $this->clients[$class] = isset($this->clients[$class])
            ? $this->clients[$class]
            : new $class($this->httpClient, $this);

        return $this->clients[$class];
    }
}
