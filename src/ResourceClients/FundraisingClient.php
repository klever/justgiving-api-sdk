<?php

namespace Konsulting\JustGivingApiSdk\ResourceClients;

use Konsulting\JustGivingApiSdk\ResourceClients\Models\AddImageRequest;
use Konsulting\JustGivingApiSdk\ResourceClients\Models\AddPostToPageUpdateRequest;
use Konsulting\JustGivingApiSdk\ResourceClients\Models\AddVideoRequest;
use Konsulting\JustGivingApiSdk\ResourceClients\Models\FundraisingPage;
use Konsulting\JustGivingApiSdk\ResourceClients\Models\StoryUpdateRequest;
use Konsulting\JustGivingApiSdk\ResourceClients\Models\UpdateFundraisingPageAttributionRequest;

class FundraisingClient extends BaseClient
{
    protected $aliases = [
        'urlCheck'              => 'FundraisingPageUrlCheck',
        'suggestShortNames'     => 'SuggestPageShortNames',
        'register'              => 'RegisterFundraisingPage',
        'getById'               => 'GetFundraisingPageDetailsById',
        'getByShortName'        => 'GetFundraisingPageDetails',
        'getAllPages'           => 'GetFundraisingPages',
        'getDonations'          => 'GetFundraisingPageDonations',
        'getUpdates'            => 'PageUpdates',
        'getUpdatesV2'          => 'PageUpdatesV2',
        'getUpdatesById'        => 'PageUpdateById',
        'addPostToPageUpdate'   => 'PageUpdatesAddPost',
        'addPostToPageUpdateV2' => 'PageUpdatesAddPostV2',
        'deletePageUpdate'      => 'DeleteFundraisingPageUpdates',
        'deleteAttribution'     => 'DeleteFundraisingPageAttribution',
        'updateAttribution'     => 'UpdateFundraisingPageAttribution',
        'appendToAttribution'   => 'AppendToFundraisingPageAttribution',
        'getAttribution'        => 'GetFundraisingPageAttribution',
        'uploadImage'           => 'UploadImage',
        'uploadDefaultImage'    => 'UploadDefaultImage',
        'addImage'              => 'AddImageToFundraisingPage',
        'getImages'             => 'GetImagesForFundraisingPage',
        'addVideo'              => 'AddVideoToFundraisingPage',
        'getVideos'             => 'GetVideosForFundraisingPage',
        'cancel'                => 'CancelFundraisingPage',
    ];

    public function urlCheck($pageShortName)
    {
        return $this->head("fundraising/pages/".$pageShortName);
    }

    public function suggestShortNames($preferredName)
    {
        return $this->get("fundraising/pages/suggest?preferredName=".urlencode($preferredName));
    }

    public function register(FundraisingPage $pageCreationRequest)
    {
        return $this->put("fundraising/pages", $pageCreationRequest);
    }

    public function getById($id)
    {
        return $this->get("/fundraising/pagebyid/".$id);
    }

    public function getByShortName($pageShortName)
    {
        return $this->get("fundraising/pages/".$pageShortName);
    }

    public function getAllPages()
    {
        return $this->get("fundraising/pages");
    }

    public function getDonations($pageShortName, $pageSize = 50, $pageNumber = 0)
    {
        return $this->get("fundraising/pages/".$pageShortName."/donations"."?PageSize=".$pageSize."&PageNum=".$pageNumber);
    }

    /**
     * Cannot find any test donations with a third party reference.
     *
     * @codeCoverageIgnore
     */
    public function getDonationsByReference($pageShortName, $reference)
    {
        return $this->get("fundraising/pages/".$pageShortName."/donations/ref/".$reference);
    }

    public function UpdateStory($pageShortName, $storyUpdate)
    {
        $storyUpdateRequest = new StoryUpdateRequest();
        $storyUpdateRequest->storySupplement = $storyUpdate;

        return $this->post("fundraising/pages/".$pageShortName, $storyUpdateRequest);
    }

    public function getUpdates($pageShortName)
    {
        return $this->get("fundraising/pages/".$pageShortName."/updates/");
    }

    public function getUpdatesV2($pageShortName, $pageSize = 25)
    {
        return $this->get("fundraising/pages/".$pageShortName."/updatesv2/?pageSize=".$pageSize);
    }

    public function getUpdatesById($pageShortName, $updateId)
    {
        return $this->get("fundraising/pages/".$pageShortName."/updates/".$updateId);
    }

    /**
     * @param $pageShortName
     * @param  AddPostToPageUpdateRequest|array  $addPostToPageUpdateRequest
     *
     * @return \Konsulting\JustGivingApiSdk\Support\Response|\Psr\Http\Message\ResponseInterface
     */
    public function addPostToPageUpdate($pageShortName, $addPostToPageUpdateRequest)
    {
        return $this->post("fundraising/pages/".$pageShortName."/updates/", $addPostToPageUpdateRequest);
    }

    /**
     * @param $pageShortName
     * @param  AddPostToPageUpdateRequest|array  $addPostToPageUpdateRequest
     *
     * @return \Konsulting\JustGivingApiSdk\Support\Response|\Psr\Http\Message\ResponseInterface
     */
    public function addPostToPageUpdateV2($pageShortName, $addPostToPageUpdateRequest)
    {
        return $this->post("fundraising/pages/".$pageShortName."/updatesv2/", $addPostToPageUpdateRequest);
    }

    public function deletePageUpdate($pageShortName, $updateId)
    {
        return $this->delete("fundraising/pages/".$pageShortName."/updates/".$updateId);
    }

    public function deleteAttribution($pageShortName)
    {
        return $this->delete("fundraising/pages/".$pageShortName."/attribution");
    }

    public function updateAttribution($pageShortName, UpdateFundraisingPageAttributionRequest $updateAttributionRequest)
    {
        return $this->put("fundraising/pages/".$pageShortName."/attribution", $updateAttributionRequest);
    }

    public function appendToAttribution($pageShortName, $appendToAttributionRequest)
    {
        return $this->post("fundraising/pages/".$pageShortName."/attribution", $appendToAttributionRequest);
    }

    public function getAttribution($pageShortName)
    {
        return $this->get("fundraising/pages/".$pageShortName."/attribution");
    }

    public function uploadImage($pageShortName, $caption, $filename, $imageContentType = null)
    {
        $url = "fundraising/pages/".$pageShortName."/images?caption=".urlencode($caption);

        return $this->postFile($url, $filename, $imageContentType);
    }

    public function uploadDefaultImage($pageShortName, $filename, $imageContentType = null)
    {
        $url = "fundraising/pages/".$pageShortName."/images/default";

        return $this->postFile($url, $filename, $imageContentType);
    }

    public function addImage($pageShortName, AddImageRequest $addImageRequest)
    {
        return $this->put("fundraising/pages/".$pageShortName."/images", $addImageRequest);
    }

    public function getImages($pageShortName)
    {
        return $this->get("fundraising/pages/".$pageShortName."/images");
    }

    public function deleteImage($pageShortName, $imageName)
    {
        return $this->delete("fundraising/pages/".$pageShortName."/images/".$imageName);
    }

    public function addVideo($pageShortName, AddVideoRequest $addVideoRequest)
    {
        return $this->put("fundraising/pages/".$pageShortName."/videos", $addVideoRequest);
    }

    public function getVideos($pageShortName)
    {
        return $this->get("fundraising/pages/".$pageShortName."/videos");
    }

    public function cancel($pageShortName)
    {
        return $this->delete("fundraising/pages/".$pageShortName);
    }
}
