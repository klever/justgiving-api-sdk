<?php

namespace Klever\JustGivingApiSdk\Tests;


use Klever\JustGivingApiSdk\Clients\Models\Address;
use Klever\JustGivingApiSdk\Clients\Models\ChangePasswordRequest;
use Klever\JustGivingApiSdk\Clients\Models\CreateAccountRequest;
use Klever\JustGivingApiSdk\Clients\Models\ValidateAccountRequest;

class AccountTest extends Base
{
    /** @test */
    public function it_can_create_a_new_account()
    {
        $uniqueId = uniqid();
        $request = new CreateAccountRequest([
            'email'                    => "test+" . $uniqueId . "@testing.com",
            'firstName'                => "first" . $uniqueId,
            'lastName'                 => "last" . $uniqueId,
            'password'                 => $this->context->testValidPassword,
            'title'                    => "Mr",
            'acceptTermsAndConditions' => true,
            'address'                  => new Address([
                'line1'             => "testLine1" . $uniqueId,
                'line2'             => "testLine2" . $uniqueId,
                'country'           => "United Kingdom",
                'countyOrState'     => "testCountyOrState" . $uniqueId,
                'townOrCity'        => "testTownOrCity" . $uniqueId,
                'postcodeOrZipcode' => "M130EJ",
            ])
        ]);

        $response = $this->client->Account->Create($request);

        $this->assertTrue($response->wasSuccessful());
    }

    /** @test */
    public function list_all_pages_when_supplied_with_a_valid_account_retrieves_pages()
    {
        $response = $this->client->Account->ListAllPages("apiunittest@justgiving.com");

        $attributes = ['pageId', 'pageTitle', 'pageStatus', 'pageShortName', 'raisedAmount', 'designId', 'companyAppealId', 'targetAmount', 'offlineDonations', 'totalRaisedOnline', 'giftAidPlusSupplement', 'pageImages'];
        $this->assertObjectHasAttributes($attributes, $response->getAttributes()[0]);
    }

    /** @test */
    public function it_checks_for_a_registered_email_and_returns_false_if_not_already_registered()
    {
        $booleanResponse = $this->client->Account->IsEmailRegistered(uniqid() . "@" . uniqid() . "-justgiving.com");

        $this->assertFalse($booleanResponse);
    }

    /** @test */
    public function it_checks_for_a_registered_email_and_returns_true_if_already_registered()
    {
        $booleanResponse = $this->client->Account->IsEmailRegistered($this->context->testUsername);

        $this->assertTrue($booleanResponse);
    }

    /** @test */
    public function it_validates_that_supplied_account_credentials_are_correct()
    {
        $request = new ValidateAccountRequest([
            'email'    => $this->context->testUsername,
            'password' => $this->context->testValidPassword,
        ]);
        $response = $this->client->Account->Validate($request)->getBodyAsObject();

        $this->assertTrue($response->consumerId > 0);
        $this->assertTrue($response->isValid);
    }

    /** @test */
    public function it_validates_account_credentials_and_returns_false_if_they_are_incorrect()
    {
        $request = new ValidateAccountRequest([
            'email'    => $this->context->testUsername,
            'password' => $this->context->testInvalidPassword,
        ]);
        $response = $this->client->Account->Validate($request);

        $this->assertEquals(0, $response->consumerId);
        $this->assertFalse($response->isValid);
    }

    /** @test */
    public function it_retrieves_account_details_when_logged_in_with_correct_credentials()
    {
        $response = $this->client->Account->Retrieve()->getBodyAsObject();

        $this->assertNotNull($response->email);
        $this->assertEquals($this->context->testUsername, $response->email);
    }

    //test change password

    /** @test */
    public function it_fails_to_change_the_account_password_when_supplied_with_an_incorrect_current_password()
    {
        $email = $this->createAccount();

        $request = new ChangePasswordRequest([
            'emailAddress'    => $email,
            'newPassword'     => 'newPassword',
            'currentPassword' => 'INVALID PASSWORD',
        ]);
        $response = $this->client->Account->ChangePassword($request);

        $this->assertFalse($response->wasSuccessful());
    }

    /** @test */
    public function it_changes_the_account_password_when_supplied_with_the_current_password()
    {
        $email = $this->createAccount();

        $request = new ChangePasswordRequest([
            'emailAddress'    => $email,
            'newPassword'     => 'newPassword',
            'currentPassword' => $this->context->testValidPassword,
        ]);
        $response = $this->client->Account->ChangePassword($request);

        $this->assertTrue($response->wasSuccessful());
    }

    /** @test */
    public function it_retrieves_a_list_of_all_donations_when_supplied_with_the_correct_credentials()
    {
        $response = $this->client->Account->AllDonations()->getBodyAsObject();

        $attributes = ['amount', 'currencyCode', 'donationDate', 'donationRef', 'donorDisplayName', 'donorLocalAmount', 'donorLocalCurrencyCode'];
        $this->assertObjectHasAttributes($attributes, $response->donations[0]);
        $this->assertTrue(is_array($response->donations));
    }

    /** @test */
    public function get_rating_history_when_supplied_authentication_return_list_of_ratings()
    {
        $response = $this->client->Account->RatingHistory();

        $this->assertNotNull($response->body);
    }

    /**
     * Creates an account and returns the email address.
     *
     * @param string $email
     * @return string
     */
    protected function createAccount($email = null)
    {
        $uniqueId = uniqid();
        $request = new CreateAccountRequest([
            'email'     => $email ?: "test+" . $uniqueId . "@testing.com",
            'firstName' => "first" . $uniqueId,
            'lastName'  => "last" . $uniqueId,
            'password'  => $this->context->testValidPassword,
            'title'     => "Mr",

            'address' => new Address([
                'line1'             => "testLine1" . $uniqueId,
                'line2'             => "testLine2" . $uniqueId,
                'country'           => "United Kingdom",
                'countyOrState'     => "testCountyOrState" . $uniqueId,
                'townOrCity'        => "testTownOrCity" . $uniqueId,
                'postcodeOrZipcode' => "M130EJ",
            ]),

            'acceptTermsAndConditions' => true
        ]);

        return $this->client->Account->Create($request)->wasSuccessful()
            ? $request->email
            : null;
    }
}
