<?php

namespace Klever\JustGivingApiSdk;

use Klever\JustGivingApiSdk\Clients\AccountApi;
use Klever\JustGivingApiSdk\Clients\CampaignApi;
use Klever\JustGivingApiSdk\Clients\CharityApi;
use Klever\JustGivingApiSdk\Clients\CountriesApi;
use Klever\JustGivingApiSdk\Clients\CurrencyApi;
use Klever\JustGivingApiSdk\Clients\DonationApi;
use Klever\JustGivingApiSdk\Clients\EventApi;
use Klever\JustGivingApiSdk\Clients\Http\CurlWrapper;
use Klever\JustGivingApiSdk\Clients\LeaderboardApi;
use Klever\JustGivingApiSdk\Clients\OneSearchApi;
use Klever\JustGivingApiSdk\Clients\PageApi;
use Klever\JustGivingApiSdk\Clients\ProjectApi;
use Klever\JustGivingApiSdk\Clients\SearchApi;
use Klever\JustGivingApiSdk\Clients\SmsApi;
use Klever\JustGivingApiSdk\Clients\TeamApi;
use Klever\JustGivingApiSdk\Exceptions\ClassNotFoundException;

class JustGivingClient
{
    public $ApiKey;
    public $ApiVersion;
    public $Username;
    public $Password;
    public $RootDomain;

//    public $Page;
//    public $Account;
//    public $Charity;
//    public $Donation;
//    public $Search;
//    public $Event;
//    public $Team;
//    public $Countries;
//    public $Currency;
//    public $OneSearch;
//    public $Project;
//    public $Sms;
//    public $Leaderboard;
//    public $Campaign;

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
        $this->curlWrapper = new CurlWrapper();
        $this->debug = false;

        // Init API clients
//        $this->Page = new PageApi($this);
//        $this->Account = new AccountApi($this);
//        $this->Charity = new CharityApi($this);
//        $this->Donation = new DonationApi($this);
//        $this->Search = new SearchApi($this);
//        $this->Event = new EventApi($this);
//        $this->Team = new TeamApi($this);
//        $this->Countries = new CountriesApi($this);
//        $this->Currency = new CurrencyApi($this);
//        $this->OneSearch = new OneSearchApi($this);
//        $this->Project = new ProjectApi($this);
//        $this->Sms = new SmsApi($this);
//        $this->Leaderboard = new LeaderboardApi($this);
//        $this->Campaign = new CampaignApi($this);
    }

    /**
     * @param string $property
     * @return mixed
     * @throws \Exception
     */
    public function __get($property)
    {
        $class = __NAMESPACE__ . '\\Clients\\' . $property . 'Api';

        if (class_exists($class)) {
            return new $class($this);
        }

        throw new ClassNotFoundException($class);
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
