<?php

namespace Konsulting\JustGivingApiSdk\Tests\Support;

use GuzzleHttp\Psr7\Response as GuzzleResponse;
use Konsulting\JustGivingApiSdk\Exceptions\UnexpectedStatusException;
use Konsulting\JustGivingApiSdk\ResourceClients\Models\CreateAccountRequest;
use Konsulting\JustGivingApiSdk\Support\Response;
use Konsulting\JustGivingApiSdk\Tests\ResourceClients\ResourceClientTestCase;

class ResponseTest extends ResourceClientTestCase
{
    /**
     * Get a response object representative of that which would be returned from the API.
     *
     * @return Response
     */
    protected function exampleResponse()
    {
        $body = [
            'donations' => [
                ['amount' => 100],
            ],
        ];

        $guzzleResponse = new GuzzleResponse(
            200,
            $headers = [],
            json_encode($body),
            '1.1',
            'OK'
        );

        return new Response($guzzleResponse);
    }

    /** @test */
    public function attributes_can_be_called_as_magic_properties()
    {
        $response = $this->exampleResponse();

        $this->assertTrue(is_numeric($response->body->donations[0]->amount));
    }

    /** @test */
    public function attributes_can_be_retrieved_with_the_get_attribute_method()
    {
        $response = $this->exampleResponse();

        $this->assertTrue(is_numeric($response->getAttribute('donations')[0]->amount));
    }

    /** @test */
    public function the_body_attribute_returns_the_decoded_json_response()
    {
        $response = $this->exampleResponse();

        $this->assertTrue(is_numeric($response->body->donations[0]->amount));
    }

    /** @test */
    public function the_errors_attribute_returns_an_empty_array_if_no_valid_errors_are_sent()
    {
        $response = $this->exampleResponse();

        $this->assertEquals([], $response->errors);
    }

    /** @test */
    public function the_errors_attribute_returns_an_array_containing_many_errors()
    {
        $uniqueId = uniqid();
        $email = 'user' . $uniqueId . '@testing.com';
        $response = $this->createAccount($email, [
            'firstName'                => '',
            'acceptTermsAndConditions' => false,
        ]);

        $this->assertEquals([
            'FirstNameNotSpecified'              => 'The FirstName field is required.',
            'AcceptTermsAndConditionsMustBeTrue' => 'You must agree to the terms and conditions',
            'ReasonPhrase'                       => 'Validation errors occured.',
        ], $response->errors);
    }

    /** @test */
    public function the_errors_attribute_returns_an_array_containing_a_single_general_error_message()
    {
        $email = 'user' . uniqid() . '@testing.com';
        $this->createAccount($email);
        $response = $this->createAccount($email);

        $this->assertContains('That email address is already in use', $response->errors);
    }

    /** @test */
    public function it_checks_if_any_errors_are_present()
    {
        $responseWithoutErrors = $this->exampleResponse();
        $responseWithErrors = $this->client->account->create(new CreateAccountRequest());

        $this->assertFalse($responseWithoutErrors->hasErrorMessages());
        $this->assertTrue($responseWithErrors->hasErrorMessages());
    }

    /** @test */
    public function it_throws_an_exception_if_an_existence_check_does_not_receive_a_valid_response_code()
    {
        $response = new Response(
            (new GuzzleResponse())->withStatus(100)
        );

        $this->expectException(UnexpectedStatusException::class);

        $response->existenceCheck();
    }

    /** @test */
    public function it_returns_an_empty_errors_array_if_the_request_was_successful()
    {
        $response = new Response(
            (new GuzzleResponse())->withStatus(200)
        );

        $this->assertEquals([], $response->errors);
    }
}
