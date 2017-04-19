<?php

namespace Klever\JustGivingApiSdk\Tests;


use Klever\JustGivingApiSdk\Clients\Models\ChangePasswordRequest;
use Klever\JustGivingApiSdk\Clients\Models\CreateAccountRequest;
use Klever\JustGivingApiSdk\Clients\Models\ValidateAccountRequest;

class AccountTest extends Base
{
    /** @test */
    public function create_when_supplied_with_valid_new_account_details_creates_account()
    {
        $uniqueId = uniqid();
        $request = new CreateAccountRequest();
        $request->email = "test" . $uniqueId . "@justgiving.com";
        $request->firstName = "first" . $uniqueId;
        $request->lastName = "last" . $uniqueId;
        $request->password = "testpassword";
        $request->title = "Mr";
        $request->address->line1 = "testLine1" . $uniqueId;
        $request->address->line2 = "testLine2" . $uniqueId;
        $request->address->country = "United Kingdom";
        $request->address->countyOrState = "testCountyOrState" . $uniqueId;
        $request->address->townOrCity = "testTownOrCity" . $uniqueId;
        $request->address->postcodeOrZipcode = "M130EJ";
        $request->acceptTermsAndConditions = true;
        $response = $this->client->Account->Create($request);

//        dump($response);
        $this->assertEquals(200, $response->getStatusCode());
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
        $booleanResponse = $this->client->Account->IsEmailRegistered($this->context->TestUsername);

        $this->assertTrue($booleanResponse);
    }

    /** @test */
    public function it_validates_that_supplied_account_credentials_are_correct()
    {
        $request = new ValidateAccountRequest();
        $request->email = $this->context->TestUsername;
        $request->password = $this->context->TestValidPassword;
        $response = $this->client->Account->IsValid($request)->getBodyAsObject();

        $this->assertTrue($response->consumerId > 0);
        $this->assertTrue($response->isValid);
    }

    /** @test */
    public function it_validates_account_credentials_and_returns_false_if_they_are_incorrect()
    {
        $request = new ValidateAccountRequest();
        $request->email = $this->context->TestUsername;
        $request->password = $this->context->TestInvalidPassword;
        $response = $this->client->Account->IsValid($request)->getBodyAsObject();

        $this->assertEquals($response->consumerId, 0);
        $this->assertFalse($response->isValid);
    }

    /** @test */
    public function it_retrieves_account_details_when_logged_in_with_correct_credentials()
    {
        $response = $this->client->Account->AccountDetails()->getBodyAsObject();

        $this->assertNotNull($response->email);
        $this->assertEquals($this->context->TestUsername, $response->email);
    }

    //test change password

    /** @test */
    public function it_fails_to_change_the_account_password_when_supplied_with_an_incorrect_current_password()
    {
        $uniqueId = uniqid();
        $request = new CreateAccountRequest();
        $request->email = "test" . $uniqueId . "@testing.com";
        $request->firstName = "first" . $uniqueId;
        $request->lastName = "last" . $uniqueId;
        $request->password = "testpassword";
        $request->title = "Mr";
        $request->address->line1 = "testLine1" . $uniqueId;
        $request->address->line2 = "testLine2" . $uniqueId;
        $request->address->country = "United Kingdom";
        $request->address->countyOrState = "testCountyOrState" . $uniqueId;
        $request->address->townOrCity = "testTownOrCity" . $uniqueId;
        $request->address->postcodeOrZipcode = "M130EJ";
        $request->acceptTermsAndConditions = true;
        $response = $this->client->Account->Create($request);

        $badPassword = 'password';

        $cpRequest = new ChangePasswordRequest();
        $cpRequest->emailaddress = $request->email;
        $cpRequest->newpassword = $badPassword;
        $cpRequest->currentpassword = $badPassword;
        $response = $this->client->Account->ChangePassword($cpRequest)->getBodyAsObject();

        $this->assertFalse($response->success);
    }

    /** @test */
    public function it_changes_the_account_password_when_supplied_with_the_current_password()
    {
        $uniqueId = uniqid();
        $request = new CreateAccountRequest();
        $request->email = "test+" . $uniqueId . "@test.com";
        $request->firstName = "first" . $uniqueId;
        $request->lastName = "last" . $uniqueId;
        $request->password = "testPassword";
        $request->title = "Mr";
        $request->address->line1 = "testLine1" . $uniqueId;
        $request->address->line2 = "testLine2" . $uniqueId;
        $request->address->country = "United Kingdom";
        $request->address->countyOrState = "testCountyOrState" . $uniqueId;
        $request->address->townOrCity = "testTownOrCity" . $uniqueId;
        $request->address->postcodeOrZipcode = "M130EJ";
        $request->acceptTermsAndConditions = true;
        $response = $this->client->Account->Create($request);

        $cpRequest = new ChangePasswordRequest();
        $cpRequest->emailaddress = $request->email;
        $cpRequest->newpassword = 'password';
        $cpRequest->currentpassword = $request->password;
        $response = $this->client->Account->ChangePassword($cpRequest)->getBodyAsObject();

        $this->assertTrue($response->success);
    }

    /** @test */
    public function it_retrieves_a_list_of_all_donations_when_supplied_with_the_correct_credentials()
    {
        $response = $this->client->Account->AllDonations()->getBodyAsObject();

        $attributes = ['amount', 'currencyCode', 'donationDate', 'donationRef', 'donorDisplayName', 'donorLocalAmount', 'donorLocalCurrencyCode'];
        $this->assertObjectHasAttributes($attributes, $response->donations[0]);
        $this->assertTrue(is_array($response->donations));

        $response->body[0];
    }

    /** @test */
    public function get_rating_history_when_supplied_authentication_return_list_of_ratings()
    {
        $response = $this->client->Account->RatingHistory()->getBodyAsObject();

        $this->assertNotNull($response);
    }
}
