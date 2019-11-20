<?php

namespace Konsulting\JustGivingApiSdk\Tests\ResourceClients;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Konsulting\JustGivingApiSdk\JustGivingClient;
use Konsulting\JustGivingApiSdk\Tests\TestCase;
use Mockery;
use Psr\Http\Message\RequestInterface;

class JustGivingClientOverloadTest extends TestCase
{
    /**
     * We're using an overload mock, which will fail if the class has already been loaded for another test.
     *
     * @var bool
     */
    protected $runTestInSeparateProcess = true;

    /** @test */
    public function it_automatically_instantiates_a_psr_18_client()
    {
        // Overload the Guzzle client class to make sure the JustGiving client is instantiating it internally
        $http = Mockery::mock('overload:' . Client::class);
        $http->shouldReceive('send')
            ->withArgs(function (RequestInterface $request) {
                return $request->getUri()->__toString() === 'https://api.justgiving.com/v1/account';
            })
            ->once()
            ->andReturn(new Response);

        $client = new JustGivingClient($this->getAuthMock());

        $client->Account->retrieve();
    }
}
