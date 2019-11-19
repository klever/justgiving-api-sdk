<?php

namespace Konsulting\JustGivingApiSdk\Tests\ResourceClients;

use GuzzleHttp\ClientInterface;
use Konsulting\JustGivingApiSdk\Exceptions\ClassNotFoundException;
use Konsulting\JustGivingApiSdk\JustGivingClient;
use Konsulting\JustGivingApiSdk\ResourceClients\AccountClient;

class JustGivingClientTest extends ResourceClientTestCase
{
    /** @test */
    public function it_returns_an_api_client_class_from_a_property_call()
    {
        $this->assertInstanceOf(AccountClient::class, $this->client->account);
        $this->assertInstanceOf(AccountClient::class, $this->client->Account);
    }

    /** @test */
    public function it_throws_an_exception_if_a_non_existent_class_name_is_called()
    {
        $this->expectException(ClassNotFoundException::class);

        $this->client->InvalidClass;
    }

    /** @test */
    public function it_returns_the_same_client_class_instance_if_called_twice()
    {
        $clientOne = $this->client->account;
        $clientTwo = $this->client->account;

        $this->assertSame($clientOne, $clientTwo);
    }

    /** @test */
    public function it_uses_a_default_base_url_and_api_version()
    {
        $http = \Mockery::mock(ClientInterface::class);
        $http->shouldReceive('request')
            ->withArgs(['get', 'https://api.justgiving.com/v1/account', []])
            ->once();

        $client = new JustGivingClient($http);

        $client->Account->retrieve();
    }

    /** @test */
    public function it_uses_the_given_base_url_and_api_version()
    {
        $http = \Mockery::mock(ClientInterface::class);
        $http->shouldReceive('request')
            ->withArgs(['get', 'https://example.com/v3/account', []])
            ->once();

        $client = new JustGivingClient($http, [
            'root_domain' => 'https://example.com',
            'api_version' => 3,
        ]);

        $client->Account->retrieve();
    }
}
