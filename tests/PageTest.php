<?php

namespace Klever\JustGivingApiSdk\Tests;

use Klever\JustGivingApiSdk\Clients\Models\AddPostToPageUpdateRequest;
use Klever\JustGivingApiSdk\Clients\Models\RegisterPageRequest;

class PageTest extends Base
{
    public function it_retrieves_page_data_when_given_a_page_short_name()
    {
        $json = $this->client->fundraising->getByShortName("rasha25");
        $this->assertEquals($json->pageId, 640916);
        $this->assertEquals($json->activityId, 73347);
        $this->assertEquals($json->eventName, "rasha25");
        $this->assertEquals($json->pageShortName, "rasha25");
        $this->assertEquals($json->status, "Active");
        $this->assertEquals($json->owner, "Itgtm Wqepuy");
    }

    public function testListAll_WithValidCredentials_ReturnsListOfUserPages()
    {
        $pages = $this->client->fundraising->getAllPages();
        $this->assertTrue(count($pages) > 0);
    }

    /**
     * test creating a page with a custom story.
     */
    public function testCreatePageWithStory()
    {
        $dto = new RegisterPageRequest();
        $dto->reference = "12345";
        $dto->pageShortName = "api-test-" . uniqid();
        $dto->activityType = "OtherCelebration";
        $dto->pageTitle = "api test";
        $dto->pageStory = "This is my custom page story, which will override the default.";
        $dto->eventName = "The Other Occasion of ApTest and APITest";
        $dto->charityId = 2050;
        $dto->targetAmount = 20;
        $dto->eventDate = "/Date(1235764800000)/";
        $dto->justGivingOptIn = true;
        $dto->charityOptIn = true;
        $dto->charityFunded = false;
        $page = $this->client->fundraising->register($dto);

        $this->assertNotNull($page);
        $this->assertNotNull($page->next->uri);
        $this->assertNotNull($page->pageId);
        $json = $this->client->fundraising->getByShortName($dto->pageShortName);
        $this->assertEquals($json->story, '<p>This is my custom page story, which will override the default.</p>');
    }

    public function testCreate_ValidCredentials_CreatesNewPage()
    {
        $dto = new RegisterPageRequest();
        $dto->reference = "12345";
        $dto->pageShortName = "api-test-" . uniqid();
        $dto->activityType = "OtherCelebration";
        $dto->pageTitle = "api test";
        $dto->eventName = "The Other Occasion of ApTest and APITest";
        $dto->charityId = 2050;
        $dto->targetAmount = 20;
        $dto->eventDate = "/Date(1235764800000)/";
        $dto->justGivingOptIn = true;
        $dto->charityOptIn = true;
        $dto->charityFunded = false;
        $page = $this->client->fundraising->register($dto);
        $this->assertNotNull($page);
        $this->assertNotNull($page->next->uri);
        $this->assertNotNull($page->pageId);
    }

    public function IsShortNameRegistered_KnownPage_Returns()
    {
        $pageShortName = "rasha25";
        $booleanResponse = $this->client->fundraising->urlCheck($pageShortName);
        $this->assertTrue($booleanResponse);
        $pageShortName = uniqid();
        $booleanResponse = $this->client->fundraising->urlCheck($pageShortName);
        $this->assertFalse($booleanResponse);
    }

    public function testUpdatePageStory_ForKnownPageWithValidCredentials_UpdatesStory()
    {
        $dto = new RegisterPageRequest();
        $dto->reference = "12345";
        $dto->pageShortName = "api-test-" . uniqid();
        $dto->activityType = "OtherCelebration";
        $dto->pageTitle = "api test";
        $dto->eventName = "The Other Occasion of ApTest and APITest";
        $dto->charityId = 2050;
        $dto->targetAmount = 20;
        $dto->eventDate = "/Date(1235764800000)/";
        $dto->justGivingOptIn = true;
        $dto->charityOptIn = true;
        $dto->charityFunded = false;
        $page = $this->client->fundraising->register($dto);
        $update = "Updated this story with update - " . uniqid();
        $response = $this->client->fundraising->UpdateStory($dto->pageShortName, $update);

        $this->assertTrue($response->wasSuccessful());
    }

    /** @test */
    public function it_uploads_an_image_and_caption_to_a_page()
    {
        $dto = new RegisterPageRequest();
        $dto->reference = "12345";
        $dto->pageShortName = "api-test-" . uniqid();
        $dto->activityType = "OtherCelebration";
        $dto->pageTitle = "api test";
        $dto->eventName = "The Other Occasion of ApTest and APITest";
        $dto->charityId = 2050;
        $dto->targetAmount = 20;
        $dto->eventDate = "/Date(1235764800000)/";
        $dto->justGivingOptIn = true;
        $dto->charityOptIn = true;
        $dto->charityFunded = false;
        $page = $this->client->fundraising->register($dto);

        $caption = "PHP Image Caption - " . uniqid();
        $filename = __DIR__ . "/img/jpg.jpg";
        $response = $this->client->fundraising->UploadImage($dto->pageShortName, $caption, $filename);

        $this->assertTrue($response->wasSuccessful());
    }

    public function testAddPostToPageUpdate_WhenSuppliedValidRequest_ReturnResponse()
    {
        $request = new AddPostToPageUpdateRequest();
        $request->Message = "update story";
        $response = $this->client->fundraising->AddPostToPageUpdate("api-test-54787f3435f75", $request);
        $this->assertNotNull($response->Created);
    }

    /** @test */
    public function it_checks_if_a_page_short_name_is_registered()
    {
        $response = $this->client->fundraising->urlCheck('rasha25');

        $this->assertTrue($response->existenceCheck());
    }
}
