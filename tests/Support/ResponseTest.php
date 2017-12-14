<?php

namespace Klever\JustGivingApiSdk\Tests\Support;

use GuzzleHttp\Psr7\Response as GuzzleResponse;
use Klever\JustGivingApiSdk\Exceptions\UnexpectedStatusException;
use Klever\JustGivingApiSdk\ResourceClients\Models\CreateAccountRequest;
use Klever\JustGivingApiSdk\Support\Response;
use Klever\JustGivingApiSdk\Tests\ResourceClients\ResourceClientTestCase;
use Psr\Http\Message\ResponseInterface;

class ResponseTest extends ResourceClientTestCase
{
    /**
     * @var Response
     */
    protected static $donationResponse;

    /**
     * @var string
     */
    protected $savedResponseDirectory = __DIR__ . '/../responses/';

    protected $savedResponses = [
        [
            'resource' => 'account',
            'action'   => 'getDonations'
        ]
    ];

    protected function setUp()
    {
        parent::setUp();

        static::$donationResponse = static::$donationResponse ?: $this->client->account->getDonations();
    }

    /**
     * Build up a response object from data contained in a JSON file.
     *
     * @param string $name
     * @return Response
     */
    protected function buildResponseFromFile($name)
    {
        $responseData = json_decode($this->savedResponseDirectory . $name . '.json');
        $guzzleResponse = new GuzzleResponse(
            $responseData->status_code,
            $headers = [],
            $responseData->body,
            '1.1',
            $responseData->reason_phrase
        );

        return new Response($guzzleResponse);
    }

    /**
     * Take a JSON representation of a response's status code, reason phrase and body, and save it to file.
     *
     * @param string            $name
     * @param ResponseInterface $response
     * @return bool|int
     */
    protected function saveResponseToFile($name, ResponseInterface $response)
    {
        $responseArray = [
            'status_code'   => $response->getStatusCode(),
            'reason_phrase' => $response->getReasonPhrase(),
            'body'          => json_decode($response->getBody()->__toString()),
        ];

        return file_put_contents($this->savedResponseDirectory . $name . '.json', json_encode($responseArray));
    }

    /** @test */
    public function attributes_can_be_called_as_magic_properties()
    {
        $response = static::$donationResponse;

        $this->assertTrue(is_numeric($response->body->donations[0]->amount));
    }

    /** @test */
    public function attributes_can_be_retrieved_with_the_get_attribute_method()
    {
        $response = static::$donationResponse;

        $this->assertTrue(is_numeric($response->getAttribute('donations')[0]->amount));
    }

    /** @test */
    public function the_body_attribute_returns_the_decoded_json_response()
    {
        $response = static::$donationResponse;

        $this->assertTrue(is_numeric($response->body->donations[0]->amount));
    }

    /** @test */
    public function the_errors_attribute_returns_an_empty_array_if_no_valid_errors_are_sent()
    {
        $response = static::$donationResponse;

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
            'AcceptTermsAndConditionsMustBeTrue' => 'You must agree to the terms and conditions',
            'ReasonPhrase'                       => 'Validation errors occured.'
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
        $responseWithoutErrors = static::$donationResponse;
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
