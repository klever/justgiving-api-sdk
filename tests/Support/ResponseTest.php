<?php

namespace Klever\JustGivingApiSdk\Tests\Support;

use Klever\JustGivingApiSdk\ResourceClients\Models\CreateAccountRequest;
use Klever\JustGivingApiSdk\Support\Response;
use Klever\JustGivingApiSdk\Tests\Base;

class ResponseTest extends Base
{
    /**
     * @var Response
     */
    protected $donationResponse;

    protected function setUp()
    {
        parent::setUp();

        $this->donationResponse = $this->client->account->getDonations();
    }

    /** @test */
    public function attributes_can_be_called_as_magic_properties()
    {
        $response = $this->donationResponse;

        $this->assertTrue(is_numeric($response->donations[0]->amount));
    }

    /** @test */
    public function attributes_can_be_retrieved_with_the_get_attribute_method()
    {
        $response = $this->donationResponse;

        $this->assertTrue(is_numeric($response->getAttribute('donations')[0]->amount));
    }

    /** @test */
    public function the_body_attribute_returns_the_decoded_json_response()
    {
        $response = $this->donationResponse;

        $this->assertTrue(is_numeric($response->body->donations[0]->amount));
    }

    /** @test */
    public function the_errors_attribute_returns_an_empty_array_if_no_valid_errors_are_sent()
    {
        $response = $this->donationResponse;

        $this->assertEquals([], $response->errors);
    }

    /** @test */
    public function the_errors_attribute_returns_an_array_containing_many_errors()
    {
        $uniqueId = uniqid();
        $email = 'user' . $uniqueId . '@testing.com';
        $response = $this->createAccount($email, [
            'firstName'                => '',
            'acceptTermsAndConditions' => false
        ]);

        $this->assertEquals([
            'FirstNameNotSpecified'              => 'The FirstName field is required.',
            'AcceptTermsAndConditionsMustBeTrue' => 'You must agree to the terms and conditions'
        ], $response->errors);
    }

    /** @test */
    public function the_errors_attribute_returns_an_array_containing_a_single_general_error_message()
    {
        $email = 'user' . uniqid() . '@testing.com';
        $this->createAccount($email);
        $response = $this->createAccount($email);

        $this->assertEquals(['General' => 'That email address is already in use'], $response->errors);
    }

    /** @test */
    public function it_checks_if_any_errors_are_present()
    {
        $responseWithoutErrors = $this->donationResponse;
        $responseWithErrors = $this->client->account->create(new CreateAccountRequest());

        $this->assertFalse($responseWithoutErrors->hasErrorMessages());
        $this->assertTrue($responseWithErrors->hasErrorMessages());
    }
}
