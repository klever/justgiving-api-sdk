<?php

namespace Klever\JustGivingApiSdk;

use GuzzleHttp\ClientInterface;
use Klever\JustGivingApiSdk\Clients\AccountApi;
use Klever\JustGivingApiSdk\Clients\CampaignApi;
use Klever\JustGivingApiSdk\Clients\CharityApi;
use Klever\JustGivingApiSdk\Clients\CountriesApi;
use Klever\JustGivingApiSdk\Clients\CurrencyApi;
use Klever\JustGivingApiSdk\Clients\DonationApi;
use Klever\JustGivingApiSdk\Clients\EventApi;
use Klever\JustGivingApiSdk\Clients\LeaderboardApi;
use Klever\JustGivingApiSdk\Clients\PageApi;
use Klever\JustGivingApiSdk\Clients\ProjectApi;
use Klever\JustGivingApiSdk\Clients\SearchApi;
use Klever\JustGivingApiSdk\Clients\SmsApi;
use Klever\JustGivingApiSdk\Clients\TeamApi;
use Klever\JustGivingApiSdk\Exceptions\ClassNotFoundException;

/**
 * Class JustGivingClient
 *
 * @property AccountApi     account
 * @property CampaignApi    campaign
 * @property CharityApi     charity
 * @property CountriesApi   countries
 * @property CurrencyApi    currency
 * @property DonationApi    donation
 * @property EventApi       event
 * @property LeaderboardApi leaderboard
 * @property PageApi        page
 * @property ProjectApi     project
 * @property SearchApi      search
 * @property SmsApi         sms
 * @property TeamApi        team
 * @property AccountApi     Account
 * @property CampaignApi    Campaign
 * @property CharityApi     Charity
 * @property CountriesApi   Countries
 * @property CurrencyApi    Currency
 * @property DonationApi    Donation
 * @property EventApi       Event
 * @property LeaderboardApi Leaderboard
 * @property PageApi        Page
 * @property ProjectApi     Project
 * @property SearchApi      Search
 * @property SmsApi         Sms
 * @property TeamApi        Team
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
}
