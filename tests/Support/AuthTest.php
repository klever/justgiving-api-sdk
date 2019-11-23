<?php

namespace Konsulting\JustGivingApiSdk\Tests\Support;

use Konsulting\JustGivingApiSdk\Support\Auth\AppAuth;
use Konsulting\JustGivingApiSdk\Support\Auth\AuthValue;
use Konsulting\JustGivingApiSdk\Support\Auth\BasicAuth;
use Konsulting\JustGivingApiSdk\Support\Auth\BearerAuth;
use Konsulting\JustGivingApiSdk\Tests\TestCase;

class AuthTest extends TestCase
{
    /**
     * @test
     * @dataProvider clientAuthProvider
     */
    public function it_returns_the_expected_headers_for_the_given_credentials(AuthValue $auth, $expectedHeaders)
    {
        $this->assertSame($auth->getHeaders(), $expectedHeaders);
    }

    public function clientAuthProvider()
    {
        return [
            [
                new BasicAuth('my_key', 'my user', 'pass123'),
                [
                    'Authorization' => 'Basic ' . base64_encode('my user:pass123'),
                    'x-api-key'     => 'my_key',
                ],
            ],
            [
                new BearerAuth('my_key', 'oauth_secret', 'my_token'),
                [
                    'Authorization'     => 'Bearer my_token',
                    'x-api-key'         => 'my_key',
                    'x-application-key' => 'oauth_secret',
                ],
            ],
            [new AppAuth('my_key'), ['x-api-key' => 'my_key']],
            [
                new AppAuth('my_key', 'secret_key'),
                [
                    'x-api-key'         => 'my_key',
                    'x-application-key' => 'secret_key',
                ],
            ],
        ];
    }
}
