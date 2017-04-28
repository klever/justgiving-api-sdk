<?php

namespace Klever\JustGivingApiSdk\Tests\ResourceClients;

use Klever\JustGivingApiSdk\Exceptions\ClassNotFoundException;
use Klever\JustGivingApiSdk\ResourceClients\AccountClient;
use Klever\JustGivingApiSdk\Tests\Base;

class JustGivingClientTest extends Base
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
}
