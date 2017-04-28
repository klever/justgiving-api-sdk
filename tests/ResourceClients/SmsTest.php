<?php

namespace Klever\JustGivingApiSdk\Tests\ResourceClients;

use Klever\JustGivingApiSdk\ResourceClients\Models\FundraisingPage;
use Klever\JustGivingApiSdk\ResourceClients\Models\RegisterPageRequest;
use Klever\JustGivingApiSdk\ResourceClients\Models\UpdatePageSmsCodeRequest;
use Klever\JustGivingApiSdk\Tests\Base;

class SmsTest extends Base
{
    public function setUp()
    {
        parent::setUp();

        sleep(5);
    }

    /** @test */
    public function it_retrieves_the_sms_code_for_a_page()
    {
        $response = $this->client->sms->getPageCode('rasha25');

        $this->assertObjectHasAttribute('urn', $response->body);
    }

    /** @test */
    public function it_updates_the_sms_code_for_a_page()
    {
        $pageShortName = "api-test-" . uniqid();
        $this->client->fundraising->register(new FundraisingPage([
            'reference'       => "12345",
            'pageShortName'   => $pageShortName,
            'activityType'    => "OtherCelebration",
            'pageTitle'       => "api test",
            'pageStory'       => "This is my custom page story, which will override the default.",
            'eventName'       => "The Other Occasion of ApTest and APITest",
            'charityId'       => 2050,
            'targetAmount'    => 20,
            'eventDate'       => "/Date(1235764800000)/",
            'justGivingOptIn' => true,
            'charityOptIn'    => true,
            'charityFunded'   => false,
        ]));

        $payload = new UpdatePageSmsCodeRequest([
            // SMS code must be 4 letters followed by a number between 47 and 99
            'urn' => chr(rand(65, 90)) . chr(rand(65, 90)) . chr(rand(65, 90)) . chr(rand(65, 90)) . rand(47, 99)
        ]);

        $response = $this->client->sms->updatePageCode($pageShortName, $payload);

        $this->assertTrue($response->wasSuccessful());
    }

    /** @test */
    public function it_checks_the_availability_of_an_sms_code()
    {
        $response = $this->client->sms->checkCodeAvailability('FOOB93');

        $this->assertObjectHasAttributes(['alternatives', 'isAvailable'], $response->body);
        $this->assertTrue(is_bool($response->body->isAvailable));
    }
}
