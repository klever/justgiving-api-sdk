<?php

namespace Konsulting\JustGivingApiSdk\Tests\ResourceClients;

use Konsulting\JustGivingApiSdk\ResourceClients\Models\FundraisingPage;
use Konsulting\JustGivingApiSdk\ResourceClients\Models\RegisterPageRequest;
use Konsulting\JustGivingApiSdk\ResourceClients\Models\UpdatePageSmsCodeRequest;

class SmsTest extends ResourceClientTestCase
{
    /** @test */
    public function it_retrieves_the_sms_code_for_a_page()
    {
        $response = $this->client->sms->getPageCode('rasha25');

        $this->assertObjectHasAttribute('urn', $response->body);
    }

    /** @test */
    public function it_updates_the_sms_code_for_a_page()
    {
        $this->markTestSkipped('No documentation found for this endpoint.');
        $pageShortName = "api-test-" . uniqid();
        $pageResponse = $this->client->fundraising->register(new FundraisingPage([
            'reference'     => "12345",
            'pageShortName' => $pageShortName,
            'activityType'  => "OtherCelebration",
            'pageTitle'     => "api test",
            'pageStory'     => "This is my custom page story, which will override the default.",
            'eventName'     => "The Other Occasion of ApTest and APITest",
            'charityId'     => 2050,
            'targetAmount'  => 20,
            'eventDate'     => "/Date(1235764800000)/",
            'charityOptIn'  => true,
            'charityFunded' => false,
        ]));

        $this->assertSuccessfulResponse($pageResponse);

        $randomChar = function () {
            return chr(rand(65, 90));
        };

        $payload = new UpdatePageSmsCodeRequest([
            // SMS code must be 4 letters followed by a number between 47 and 99
            'urn' => $randomChar() . $randomChar() . $randomChar() . $randomChar() . rand(47, 99),
        ]);

        $response = $this->client->sms->updatePageCode($pageShortName, $payload);

        $this->assertSuccessfulResponse($response);
    }

    /** @test */
    public function it_checks_the_availability_of_an_sms_code()
    {
        $response = $this->client->sms->checkCodeAvailability('FOOB93');

        $this->assertObjectHasAttributes(['alternatives', 'isAvailable'], $response->body);
        $this->assertTrue(is_bool($response->body->isAvailable));
    }
}
