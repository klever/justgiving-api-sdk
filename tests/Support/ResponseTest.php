<?php

namespace Klever\JustGivingApiSdk\Tests\Support;

use Klever\JustGivingApiSdk\Tests\Base;

class ResponseTest extends Base
{
    /** @test */
    public function attributes_can_be_called_as_magic_properties()
    {
        $response = $this->client->account->AllDonations();

        $this->assertTrue(is_numeric($response->donations[0]->amount));
    }

    /** @test */
    public function attributes_can_be_retrieved_with_the_get_attribute_method()
    {
        $response = $this->client->account->AllDonations();

        $this->assertTrue(is_numeric($response->getAttribute('donations')[0]->amount));
    }
}
