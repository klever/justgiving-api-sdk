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
        $this->assertEquals($response->email, $request->email);
    }

    /** @test */
    public function list_all_pages_when_supplied_with_a_valid_account_retrieves_pages()
    {
        $response = $this->client->Account->ListAllPages("apiunittest@justgiving.com");
        $this->assertTrue(count($response) > 0);
    }

    /** @test */
    public function is_email_registered_when_supplied_email_unlikely_to_exist_returns_false()
    {
        $booleanResponse = $this->client->Account->IsEmailRegistered(uniqid() . "@" . uniqid() . "-justgiving.com");
        $this->assertFalse($booleanResponse);
    }

    /** @test */
    public function is_email_registered_when_supplied_known_email_returns_true()
    {
        $booleanResponse = $this->client->Account->IsEmailRegistered($this->context->TestUsername);
        $this->assertTrue($booleanResponse);
    }

    /** @test */
    public function is_account_valid_when_supplied_known_email_and_password_returns_valid()
    {
        $request = new ValidateAccountRequest();
        $request->email = $this->context->TestUsername;
        $request->password = $this->context->TestValidPassword;
        $response = $this->client->Account->IsValid($request);
        $this->assertTrue($response->consumerId > 0);
        $this->assertEquals($response->isValid, 1);
    }

    /** @test */
    public function is_account_valid_when_supplied_known_email_and_password_returns_in_valid()
    {
        $request = new ValidateAccountRequest();
        $request->email = $this->context->TestUsername;
        $request->password = $this->context->TestInvalidPassword;
        $response = $this->client->Account->IsValid($request);
        $this->assertEquals($response->consumerId, 0);
        $this->assertEquals($response->isValid, 0);
    }

    /** @test */
    public function get_account_details_when_supplied_authentication_retrive_account_details()
    {
        $response = $this->client->Account->AccountDetails();
        $this->assertNotNull($response->email);
        $this->assertEquals($this->context->TestUsername, $response->email);
    }

    //test change password

    /** @test */
    public function change_account_password_when_supplied_correct_current_password_and_new_password_return_success_false()
    {
        $uniqueId = uniqid();
        $request = new CreateAccountRequest();
        $request->email = "test+" . $uniqueId . "@test.com";
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
        $response = $this->client->Account->ChangePassword($cpRequest);
        $this->assertEquals($response->success, 0);
    }

    /** @test */
    public function change_account_password_when_supplied_in_correct_current_password_and_new_password_return_success_true()
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
        $badPassword = 'password';
        $cpRequest = new ChangePasswordRequest();
        $cpRequest->emailaddress = $request->email;
        $cpRequest->newpassword = $badPassword;
        $cpRequest->currentpassword = $request->password;
        $response = $this->client->Account->ChangePassword($cpRequest);

        $this->assertEquals($response->success, 1);
    }

    /** @test */
    public function get_all_donations_when_supplied_authentication_return_list_of_donations()
    {
        $response = $this->client->Account->AllDonations();
        $this->assertNotNull($response);
    }

    /** @test */
    public function get_rating_history_when_supplied_authentication_return_list_of_ratings()
    {
        $response = $this->client->Account->RatingHistory();
        $this->assertNotNull($response);
    }
}
