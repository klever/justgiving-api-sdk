<?php

namespace Klever\JustGivingApiSdk\Tests;

use Klever\JustGivingApiSdk\Clients\AccountApi;
use Klever\JustGivingApiSdk\Exceptions\ClassNotFoundException;

class JustGivingClientTest extends Base
{
    /** @test */
    public function it_returns_a_class_based_on_an_overloaded_property_call()
    {
        $this->assertInstanceOf(AccountApi::class, $this->client->Account);
    }

    /** @test */
    public function it_throws_an_exception_if_a_non_existent_class_name_is_called()
    {
        $this->expectException(ClassNotFoundException::class);

        $this->client->InvalidClass;
    }
}
