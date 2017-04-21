<?php

namespace Klever\JustGivingApiSdk\Tests;


use Klever\JustGivingApiSdk\Clients\Models\Address;
use Klever\JustGivingApiSdk\Clients\Models\ChangePasswordRequest;
use Klever\JustGivingApiSdk\Clients\Models\CreateAccountRequest;
use Klever\JustGivingApiSdk\Clients\Models\ValidateAccountRequest;

class AccountTest extends Base
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
    public function it_checks_for_a_registered_email_and_returns_false_if_not_already_registered()
    {
        $booleanResponse = $this->client->account->isEmailRegistered(uniqid() . "@" . uniqid() . "-justgiving.com");

        $this->assertFalse($booleanResponse);
    }

    /** @test */
    public function it_checks_for_a_registered_email_and_returns_true_if_already_registered()
    {
        $booleanResponse = $this->client->account->isEmailRegistered($this->context->testUsername);

        $this->assertTrue($booleanResponse);
    }

    /** @test */
    public function it_validates_that_supplied_account_credentials_are_correct()
    {
        $request = new ValidateAccountRequest([
            'email'    => $this->context->testUsername,
            'password' => $this->context->testValidPassword,
        ]);
        $response = $this->client->account->validate($request)->getBodyAsObject();

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
        $response = $this->client->account->validate($request);

        $this->assertEquals(0, $response->consumerId);
        $this->assertFalse($response->isValid);
    }

    /** @test */
    public function it_retrieves_account_details_when_logged_in_with_correct_credentials()
    {
        $response = $this->client->account->retrieve()->getBodyAsObject();

        $this->assertNotNull($response->email);
        $this->assertEquals($this->context->testUsername, $response->email);
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
    public function it_retrieves_a_list_of_all_donations_when_supplied_with_the_correct_credentials()
    {
        $response = $this->client->account->getDonations()->getBodyAsObject();

        $attributes = ['amount', 'currencyCode', 'donationDate', 'donationRef', 'donorDisplayName', 'donorLocalAmount', 'donorLocalCurrencyCode'];
        $this->assertObjectHasAttributes($attributes, $response->donations[0]);
        $this->assertTrue(is_array($response->donations));
    }

}
