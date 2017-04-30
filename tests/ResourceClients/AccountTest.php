<?php

namespace Klever\JustGivingApiSdk\Tests\ResourceClients;

use Klever\JustGivingApiSdk\ResourceClients\Models\Address;
use Klever\JustGivingApiSdk\ResourceClients\Models\ChangePasswordRequest;
use Klever\JustGivingApiSdk\ResourceClients\Models\CreateAccountRequest;
use Klever\JustGivingApiSdk\ResourceClients\Models\ValidateAccountRequest;


class AccountTest extends ResourceClientTestCase
{
    /** @test */
    public function it_creates_a_new_account()
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

        $response = $this->client->account->create($request);

        $this->assertTrue($response->wasSuccessful());
    }

    /** @test */
    public function it_lists_all_fundraising_pages_when_supplied_with_a_valid_account()
    {
        $response = $this->client->account->listAllPages("apiunittest@justgiving.com");

        $attributes = ['pageId', 'pageTitle', 'pageStatus', 'pageShortName', 'raisedAmount', 'designId', 'companyAppealId', 'targetAmount', 'offlineDonations', 'totalRaisedOnline', 'giftAidPlusSupplement', 'pageImages'];
        $this->assertObjectHasAttributes($attributes, $response->getAttributes()[0]);
    }

    /** @test */
    public function it_checks_for_a_registered_email()
    {
        $nonRegisteredEmailResponse = $this->client->account->isEmailRegistered(uniqid() . "@" . uniqid() . "-justgiving.com");
        $alreadyRegisteredEmailResponse = $this->client->account->isEmailRegistered($this->context->testUsername);

        $this->assertFalse($nonRegisteredEmailResponse->existenceCheck());
        $this->assertTrue($alreadyRegisteredEmailResponse->existenceCheck());
    }

    /** @test */
    public function it_validates_that_supplied_account_credentials_are_correct()
    {
        $request = new ValidateAccountRequest([
            'email'    => $this->context->testUsername,
            'password' => $this->context->testValidPassword,
        ]);
        $response = $this->client->account->validate($request);

        $this->assertTrue($response->consumerId > 0);
        $this->assertTrue($response->body->isValid);
    }

    /** @test */
    public function it_validates_account_credentials_and_returns_false_if_they_are_incorrect()
    {
        $request = new ValidateAccountRequest([
            'email'    => $this->context->testUsername,
            'password' => $this->context->testInvalidPassword,
        ]);
        $response = $this->client->account->validate($request);

        $this->assertEquals(0, $response->body->consumerId);
        $this->assertFalse($response->body->isValid);
    }

    /** @test */
    public function it_retrieves_account_details_when_logged_in_with_correct_credentials()
    {
        $response = $this->client->account->retrieve();

        $this->assertNotNull($response->email);
        $this->assertEquals($this->context->testUsername, $response->body->email);
    }

    //test change password

    /** @test */
    public function it_fails_to_change_the_account_password_when_supplied_with_an_incorrect_current_password()
    {
        $email = 'user' . uniqid() . '@testing.com';
        $this->createAccount($email);

        $request = new ChangePasswordRequest([
            'emailAddress'    => $email,
            'newPassword'     => 'newPassword',
            'currentPassword' => 'INVALID PASSWORD',
        ]);
        $response = $this->client->account->changePassword($request);

        $this->assertFalse($response->wasSuccessful());
    }

    /** @test */
    public function it_changes_the_account_password_when_supplied_with_the_current_password()
    {
        $email = 'user' . uniqid() . '@testing.com';
        $this->createAccount($email);

        $request = new ChangePasswordRequest([
            'emailAddress'    => $email,
            'newPassword'     => 'newPassword',
            'currentPassword' => $this->context->testValidPassword,
        ]);
        $response = $this->client->account->changePassword($request);

        $this->assertTrue($response->wasSuccessful());
    }

    /** @test */
    public function it_retrieves_donations_by_charity()
    {
        $response = $this->client->account->getDonationsByCharity('jgdemo');

        $attributes = ['amount', 'currencyCode', 'donationDate', 'donationRef', 'donorDisplayName', 'donorLocalAmount', 'donorLocalCurrencyCode'];
        $this->assertObjectHasAttributes($attributes, $response->body->donations[0]);
        $this->assertTrue(is_array($response->body->donations));
    }

    /** @test */
    public function it_retrieves_a_list_of_all_donations_when_supplied_with_the_correct_credentials()
    {
        $response = $this->client->account->getDonations();

        $attributes = ['amount', 'currencyCode', 'donationDate', 'donationRef', 'donorDisplayName', 'donorLocalAmount', 'donorLocalCurrencyCode'];
        $this->assertObjectHasAttributes($attributes, $response->body->donations[0]);
        $this->assertTrue(is_array($response->body->donations));
    }

    /** @test */
    public function it_requests_a_password_reminder()
    {
        $response = $this->client->account->requestPasswordReminder($this->context->testUsername);

        $this->assertTrue($response->wasSuccessful());
    }
}
