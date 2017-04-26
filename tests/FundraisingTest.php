<?php

namespace Klever\JustGivingApiSdk\Tests;

use Klever\JustGivingApiSdk\ResourceClients\Models\AddImageRequest;
use Klever\JustGivingApiSdk\ResourceClients\Models\AddPostToPageUpdateRequest;
use Klever\JustGivingApiSdk\ResourceClients\Models\AddVideoRequest;
use Klever\JustGivingApiSdk\ResourceClients\Models\FundraisingPage;
use Klever\JustGivingApiSdk\ResourceClients\Models\UpdateFundraisingPageAttributionRequest;

class FundraisingTest extends Base
{
    protected $pageShortName;

    protected function setUp()
    {
        parent::setUp();

        $this->pageShortName = "api-test-" . uniqid();
        $this->client->fundraising->register(
            $this->newPage(['pageShortName' => $this->pageShortName])
        );
    }

    protected function newPage($options = [])
    {
        return new FundraisingPage(array_merge([
            'reference'       => "12345",
            'pageShortName'   => "api-test-" . uniqid(),
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
        ], $options));
    }

    /** @test */
    public function it_retrieves_page_data_when_given_a_page_short_name()
    {
        $response = $this->client->fundraising->getByShortName("rasha25");

        $this->assertEquals(640916, $response->body->pageId);
        $this->assertEquals(73347, $response->body->activityId);
        $this->assertEquals("rasha25", $response->body->eventName);
        $this->assertEquals("rasha25", $response->body->pageShortName);
        $this->assertEquals("Active", $response->body->status);
        $this->assertEquals("Itgtm Wqepuy", $response->body->owner);
    }

    /** @test */
    public function it_retrieves_all_fundraising_pages()
    {
        $response = $this->client->fundraising->getAllPages();

        $this->assertTrue(is_array($response->body));
        $this->assertObjectHasAttributes(
            ['pageId', 'pageTitle', 'pageStatus', 'pageShortName', 'raisedAmount', 'designId', 'companyAppealId', 'targetAmount'],
            $response->body[0]
        );
    }

    /** @test */
    public function it_creates_a_fundraising_page_with_a_story()
    {
        $newPage = $this->newPage(['pageStory' => 'This is my custom page story, which will override the default.']);

        $pageResponse = $this->client->fundraising->register($newPage);
        $response = $this->client->fundraising->getByShortName($newPage->pageShortName);

        $this->assertNotNull($pageResponse->body->next->uri);
        $this->assertNotNull($pageResponse->body->pageId);
        $this->assertEquals('<p>This is my custom page story, which will override the default.</p>', $response->story);
    }

    /** @test */
    public function it_creates_a_fundraising_page()
    {
        $newPage = $this->newPage();
        $response = $this->client->fundraising->register($newPage);

        $this->assertTrue($response->wasSuccessful());
        $this->assertNotNull($response->body->next->uri);
        $this->assertNotNull($response->body->pageId);
    }

    /** @test */
    public function it_checks_if_a_short_name_has_been_registered()
    {
        $pageShortName = "rasha25";
        $booleanResponse = $this->client->fundraising->urlCheck($pageShortName);
        $this->assertTrue($booleanResponse->existenceCheck());

        $pageShortName = uniqid();
        $booleanResponse = $this->client->fundraising->urlCheck($pageShortName);
        $this->assertFalse($booleanResponse->existenceCheck());
    }

    /** @test */
    public function it_retrieves_donations_by_page()
    {
        $response = $this->client->fundraising->getDonations('rasha25');

        $this->assertTrue(is_array($response->body->donations));
        $this->assertObjectHasAttributes(['amount', 'currencyCode', 'donationRef', 'donorDisplayName', 'message'], $response->body->donations[0]);
    }

    /** @test */
    public function it_gets_page_updates()
    {
        $response = $this->client->fundraising->getUpdates('api-test-54787f3435f75');

        $this->assertTrue(is_array($response->body));
        $this->assertObjectHasAttributes(['CreatedDate', 'Id', 'Message', 'Video'], $response->body[0]);
    }

    /** @test */
    public function it_gets_page_updates_by_id()
    {
        $response = $this->client->fundraising->getUpdatesById('api-test-54787f3435f75', 100125);

        $this->assertTrue($response->wasSuccessful());
        $this->assertObjectHasAttributes(['CreatedDate', 'Id', 'Message', 'Video'], $response->body);
    }

    /** @test */
    public function it_suggests_page_short_names()
    {
        $response = $this->client->fundraising->suggestShortNames('name');

        $this->assertTrue(is_array($response->body->Names));
        $this->assertTrue(is_string($response->body->Names[0]));
    }

    /** @test */
    public function it_updates_the_story_on_a_page()
    {
        $update = "Updated this story with update - " . uniqid();
        $response = $this->client->fundraising->UpdateStory($this->pageShortName, $update);

        $this->assertTrue($response->wasSuccessful());
    }

    /** @test */
    public function it_uploads_an_image_and_caption_to_a_page()
    {
        $caption = "PHP Image Caption - " . uniqid();
        $filename = __DIR__ . "/img/jpg.jpg";
        $response = $this->client->fundraising->uploadImage($this->pageShortName, $caption, $filename);

        $this->assertTrue($response->wasSuccessful());
    }

    /** @test */
    public function it_uploads_a_default_image_to_a_page()
    {
        $filename = __DIR__ . "/img/jpg.jpg";
        $response = $this->client->fundraising->uploadDefaultImage($this->pageShortName, $filename);

        $this->assertTrue($response->wasSuccessful());
    }

    /** @test */
    public function it_adds_an_image_to_the_page()
    {
        $newImage = new AddImageRequest([
            'caption'   => 'An image',
            'isDefault' => true,
            'url'       => 'https://upload.wikimedia.org/wikipedia/commons/c/c4/PM5544_with_non-PAL_signals.png'
        ]);

        $response = $this->client->fundraising->addImage($this->pageShortName, $newImage);

        $this->assertTrue($response->wasSuccessful());
        $this->assertObjectHasAttributes(['rel', 'uri', 'type'], $response->body->next);
    }

    /** @test */
    public function it_gets_images_for_a_page()
    {
        $response = $this->client->fundraising->getImages('rasha25');

        $this->assertTrue(is_array($response->body));
        $this->assertObjectHasAttributes(['caption', 'url', 'absoluteUrl'], $response->body[0]);
    }

    /** @test */
    public function it_deletes_an_image_from_a_page()
    {
        $newImage = new AddImageRequest([
            'caption'   => 'An image to delete',
            'isDefault' => false,
            'url'       => 'https://upload.wikimedia.org/wikipedia/commons/c/c4/PM5544_with_non-PAL_signals.png'
        ]);
        $this->client->fundraising->addImage($this->pageShortName, $newImage);

        // Get the image listing from the server, because images are renamed on upload
        $getImageResponse = $this->client->fundraising->getImages($this->pageShortName);
        $fileNameOnServer = pathinfo(array_slice($getImageResponse->body, -1)[0]->url, PATHINFO_FILENAME);

        $response = $this->client->fundraising->deleteImage($this->pageShortName, $fileNameOnServer . '.png');

        $this->assertTrue($response->wasSuccessful());
    }

    /** @test */
    public function it_adds_a_post_to_the_page_update()
    {
        $request = new AddPostToPageUpdateRequest(['Message' => 'update story']);

        $response = $this->client->fundraising->addPostToPageUpdate($this->pageShortName, $request);
        $this->assertNotNull($response->Created);
    }

    /** @test */
    public function it_deletes_a_page_update()
    {
        $newUpdate = new AddPostToPageUpdateRequest(['Message' => 'A message']);
        $updateResponse = $this->client->fundraising->addPostToPageUpdate($this->pageShortName, $newUpdate);
        $updateId = pathinfo($updateResponse->body->Created->uri, PATHINFO_FILENAME);

        $response = $this->client->fundraising->deletePageUpdate($this->pageShortName, $updateId);

        $this->assertTrue($response->wasSuccessful());
    }

    /** @test */
    public function it_checks_if_a_page_short_name_is_registered()
    {
        $response = $this->client->fundraising->urlCheck('rasha25');

        $this->assertTrue($response->existenceCheck());
    }

    /** @test */
    public function it_adds_a_video_to_the_page()
    {
        $newVideo = new AddVideoRequest([
            'caption'   => 'A video',
            'isDefault' => true,
            'url'       => 'https://www.youtube.com/watch?v=XTrqHP17kBw'
        ]);

        $response = $this->client->fundraising->addVideo($this->pageShortName, $newVideo);

        $this->assertTrue($response->wasSuccessful());
        $this->assertObjectHasAttributes(['rel', 'uri', 'type'], $response->body->next);
    }

    /** @test */
    public function it_gets_videos_for_a_page()
    {
        $response = $this->client->fundraising->getVideos('rasha25');

        $this->assertTrue(is_array($response->body));
        $this->assertObjectHasAttributes(['caption', 'url'], $response->body[0]);
    }

    /** @test */
    public function it_deletes_a_page()
    {
        $pageShortName = 'page' . uniqid();
        $this->client->fundraising->register($this->newPage(['pageShortName' => $pageShortName]));

        $response = $this->client->fundraising->cancel($pageShortName);

        $this->assertTrue($response->wasSuccessful());
    }

    /** @test */
    public function it_updates_a_page_attribution()
    {
        $update = new UpdateFundraisingPageAttributionRequest(['attribution'=>'An updated attribution'        ]);
        $response = $this->client->fundraising->updateAttribution($this->pageShortName, $update);
//        $details = $this->client->fundraising->
//        dd($response->getReasonPhrase(), $response->body);

        $this->assertTrue($response->wasSuccessful());
    }
}
