<?php

namespace Konsulting\JustGivingApiSdk\Tests\ResourceClients;

use Konsulting\JustGivingApiSdk\ResourceClients\Models\AddImageRequest;
use Konsulting\JustGivingApiSdk\ResourceClients\Models\AddPostToPageUpdateRequest;
use Konsulting\JustGivingApiSdk\ResourceClients\Models\AddVideoRequest;
use Konsulting\JustGivingApiSdk\ResourceClients\Models\FundraisingPage;
use Konsulting\JustGivingApiSdk\ResourceClients\Models\UpdateFundraisingPageAttributionRequest;

class FundraisingTest extends ResourceClientTestCase
{
    protected static $pageShortName;

    protected function setUp(): void
    {
        parent::setUp();

        // Create one test page to use across tests to help with API timeouts/lockouts
        // DO NOT MODIFY this response within tests
        if (! isset(static::$pageShortName)) {
            static::$pageShortName = "api-test-" . uniqid();
            $this->client->fundraising->register(
                $this->newPage(['pageShortName' => static::$pageShortName])
            );
        }
    }

    protected function newPage($options = [])
    {
        return new FundraisingPage(array_merge([
            'reference'     => "12345",
            'pageShortName' => "api-test-" . uniqid(),
            'activityType'  => "OtherCelebration",
            'pageTitle'     => "api test",
            'pageStory'     => "This is my custom page story, which will override the default.",
            'eventName'     => "The Other Occasion of ApTest and APITest",
            'charityId'     => 2050,
            'targetAmount'  => 20,
            'eventDate'     => "/Date(1235764800000)/",
            'charityOptIn'  => true,
            'charityFunded' => false,
        ], $options));
    }

    /** @test */
    public function it_retrieves_page_data_when_given_a_page_short_name()
    {
        $response = $this->client->fundraising->getByShortName("rasha25");

        $this->assertSame('640916', $response->body->pageId);
        $this->assertSame('73347', $response->body->activityId);
        $this->assertSame("rasha25", $response->body->eventName);
        $this->assertSame("rasha25", $response->body->pageShortName);
        $this->assertSame("Completed", $response->body->status);
        $this->assertSame("Rasha Hassan", $response->body->owner);
    }

    /** @test */
    public function it_retrieves_all_fundraising_pages()
    {
        $response = $this->client->fundraising->getAllPages();

        $this->assertTrue(is_array($response->body), 'Response body is not an array.');
        $this->assertObjectHasAttributes(
            [
                'pageId',
                'pageTitle',
                'pageStatus',
                'pageShortName',
                'raisedAmount',
                'designId',
                'companyAppealId',
                'targetAmount',
            ],
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

        $this->assertSuccessfulResponse($response);
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
        $this->assertObjectHasAttributes(['amount', 'currencyCode', 'donationRef', 'donorDisplayName', 'message'],
            $response->body->donations[0]);
    }

    /** @test */
    public function it_gets_page_updates()
    {
        $response = $this->client->fundraising->getUpdates('mike-page5');

        $this->assertTrue(is_array($response->body));
        $this->assertObjectHasAttributes(['CreatedDate', 'Id', 'Message', 'Video'], $response->body[0]);
    }

    /** @test */
    public function it_gets_page_updates_by_id()
    {
        $response = $this->client->fundraising->getUpdatesById('mike-page5', 913425);

        $this->assertSuccessfulResponse($response);
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
        $response = $this->client->fundraising->UpdateStory(static::$pageShortName, $update);

        $this->assertSuccessfulResponse($response);
    }

    /** @test */
    public function it_uploads_an_image_and_caption_to_a_page()
    {
        $caption = "PHP Image Caption - " . uniqid();
        $filename = __DIR__ . "/../img/jpg.jpg";
        $response = $this->client->fundraising->uploadImage(static::$pageShortName, $caption, $filename);

        $this->assertSuccessfulResponse($response);
    }

    /** @test */
    public function it_uploads_a_default_image_to_a_page()
    {
        $filename = __DIR__ . "/../img/jpg.jpg";
        $response = $this->client->fundraising->uploadDefaultImage(static::$pageShortName, $filename);

        $this->assertSuccessfulResponse($response);
    }

    /** @test */
    public function it_adds_an_image_to_the_page()
    {
        $newImage = new AddImageRequest([
            'caption'   => 'An image',
            'isDefault' => true,
            'url'       => 'https://upload.wikimedia.org/wikipedia/commons/c/c4/PM5544_with_non-PAL_signals.png',
        ]);

        $response = $this->client->fundraising->addImage(static::$pageShortName, $newImage);

        $this->assertSuccessfulResponse($response);
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
            'url'       => 'https://upload.wikimedia.org/wikipedia/commons/c/c4/PM5544_with_non-PAL_signals.png',
        ]);
        $this->client->fundraising->addImage(static::$pageShortName, $newImage);

        // Get the image listing from the server, because images are renamed on upload
        $getImageResponse = $this->client->fundraising->getImages(static::$pageShortName);
        $fileNameOnServer = pathinfo(array_slice($getImageResponse->body, -1)[0]->url, PATHINFO_FILENAME);

        $response = $this->client->fundraising->deleteImage(static::$pageShortName, $fileNameOnServer . '.png');

        $this->assertSuccessfulResponse($response);
    }

    /** @test */
    public function it_adds_a_post_to_the_page_update()
    {
        $request = new AddPostToPageUpdateRequest(['Message' => 'update story']);

        $response = $this->client->fundraising->addPostToPageUpdate(static::$pageShortName, $request);
        $this->assertNotNull($response->Created, 'Created response not received.');
    }

    /** @test */
    public function it_deletes_a_page_update()
    {
        $newUpdate = new AddPostToPageUpdateRequest(['Message' => 'A message']);
        $updateResponse = $this->client->fundraising->addPostToPageUpdate(static::$pageShortName, $newUpdate);
        $updateId = pathinfo($updateResponse->body->Created->uri, PATHINFO_FILENAME);

        $response = $this->client->fundraising->deletePageUpdate(static::$pageShortName, $updateId);

        $this->assertSuccessfulResponse($response);
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
            'url'       => 'https://www.youtube.com/watch?v=XTrqHP17kBw',
        ]);

        $response = $this->client->fundraising->addVideo(static::$pageShortName, $newVideo);

        $this->assertSuccessfulResponse($response);
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

        $this->assertSuccessfulResponse($response);
    }

    /** @test */
    public function it_updates_and_gets_a_page_attribution()
    {
        $update = new UpdateFundraisingPageAttributionRequest(['attribution' => 'An updated attribution']);
        $response = $this->client->fundraising->updateAttribution(static::$pageShortName, $update);
        $getAttribution = $this->client->fundraising->getAttribution(static::$pageShortName);

        $this->assertSuccessfulResponse($response);
        $this->assertEquals('An updated attribution', $getAttribution->body->attribution);
    }

    /** @test */
    public function it_appends_to_and_gets_a_page_attribution()
    {
        $update = new UpdateFundraisingPageAttributionRequest(['attribution' => 'Attribution. ']);
        $this->client->fundraising->updateAttribution(static::$pageShortName, $update);
        $response = $this->client->fundraising->appendToAttribution(static::$pageShortName, $update);
        $getAttribution = $this->client->fundraising->getAttribution(static::$pageShortName);

        $this->assertSuccessfulResponse($response);
        $this->assertEquals('Attribution. Attribution. ', $getAttribution->body->attribution);
    }

    /** @test */
    public function it_deletes_a_page_attribution()
    {
        $update = new UpdateFundraisingPageAttributionRequest(['attribution' => 'Attribution. ']);
        $this->client->fundraising->updateAttribution(static::$pageShortName, $update);
        $response = $this->client->fundraising->deleteAttribution(static::$pageShortName);
        $getAttribution = $this->client->fundraising->getAttribution(static::$pageShortName);

        $this->assertSuccessfulResponse($response);
        $this->assertEquals('', $getAttribution->body->attribution);
    }
}
