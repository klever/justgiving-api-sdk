<?php

namespace Klever\JustGivingApiSdk\Clients;

use Klever\JustGivingApiSdk\Clients\Models\StoryUpdateRequest;

class FundraisingApi extends BaseClient
{
    protected $aliases = [
        'urlCheck'           => 'FundraisingPageUrlCheck',
        'suggestShortNames'  => 'SuggestPageShortNames',
        'register'           => 'RegisterFundraisingPage',
        'getByShortName'     => 'GetFundraisingPageDetails',
        'GetFundraisingPageDetailsById',
        'getAllPages'        => 'GetFundraisingPages',
        'getDonations'       => 'GetFundraisingPageDonations',
        'GetFundraisingPageDonationsByReference',
        'UpdateFundraisingPage',
        'getUpdates'         => 'PageUpdates',
        'getUpdatesById'     => 'PageUpdateById',
        'PageUpdatesAddPost',
        'DeleteFundraisingPageUpdates',
        'DeleteFundraisingPageAttribution',
        'UpdateFundraisingPageAttribution',
        'AppendToFundraisingPageAttribution',
        'GetFundraisingPageAttribution',
        'uploadImage'        => 'UploadImage',
        'uploadDefaultImage' => 'UploadDefaultImage',
        'addImage'           => 'AddImageToFundraisingPage',
        'DeleteFundraisingPageImage',
        'getImages'          => 'GetImagesForFundraisingPage',
        'addVideo'           => 'AddVideoToFundraisingPage',
        'getVideos'          => 'GetVideosForFundraisingPage',
        'cancel'             => 'CancelFundraisingPage',
        'UpdateNotificationsPreferences',
        'UpdateFundraisingPageSummary',
    ];

    public function urlCheck($pageShortName)
    {
        return $this->head("fundraising/pages/" . $pageShortName);
    }

    public function suggestShortNames($preferredName)
    {
        return $this->get("fundraising/pages/suggest?preferredName=" . urlencode($preferredName));
    }

    public function register($pageCreationRequest)
    {
        return $this->put("fundraising/pages", $pageCreationRequest);
    }

    public function getByShortName($pageShortName)
    {
        return $this->get("fundraising/pages/" . $pageShortName);
    }

    public function getAllPages()
    {
        return $this->get("fundraising/pages");
    }

    public function getDonations($pageShortName, $pageSize = 50, $pageNumber = 1)
    {
        return $this->get("fundraising/pages/" . $pageShortName . "/donations" . "?PageSize=" . $pageSize . "&PageNum=" . $pageNumber);
    }

    public function getDonationsByReference($pageShortName, $reference)
    {
        return $this->get("fundraising/pages/" . $pageShortName . "/donations/ref/" . $reference);
    }

    public function UpdateStory($pageShortName, $storyUpdate)
    {
        $storyUpdateRequest = new StoryUpdateRequest();
        $storyUpdateRequest->storySupplement = $storyUpdate;

        return $this->post("fundraising/pages/" . $pageShortName, $storyUpdateRequest);
    }

    public function getUpdates($pageShortName)
    {
        return $this->get("fundraising/pages/" . $pageShortName . "/updates/");
    }

    public function getUpdatesById($pageShortName, $updateId)
    {
        return $this->get("fundraising/pages/" . $pageShortName . "/updates/" . $updateId);
    }

    public function AddPostToPageUpdate($pageShortName, $addPostToPageUpdateRequest)
    {
        return $this->post("fundraising/pages/" . $pageShortName . "/updates/", $addPostToPageUpdateRequest);
    }

    public function DeleteFundraisingPageAttribution($pageShortName)
    {
        return $this->delete("fundraising/pages/" . $pageShortName . "/attribution")->existenceCheck();
    }

    public function UpdateFundraisingPageAttribution($pageShortName, $updateFundraisingPageAttributionRequest)
    {
        return $this->put(
            "fundraising/pages/" . $pageShortName . "/attribution",
            $updateFundraisingPageAttributionRequest
        );
    }

    public function AppendToFundraisingPageAttribution($pageShortName, $appendToFundraisingPageAttributionRequest)
    {
        return $this->post(
            "fundraising/pages/" . $pageShortName . "/attribution",
            $appendToFundraisingPageAttributionRequest
        );
    }

    public function GetFundraisingPageAttribution($pageShortName)
    {
        return $this->get("fundraising/pages/" . $pageShortName . "/attribution");
    }

    public function UploadImage($pageShortName, $caption, $filename, $imageContentType = null)
    {
        $url = "fundraising/pages/" . $pageShortName . "/images?caption=" . urlencode($caption);

        return $this->postFile($url, $filename, $imageContentType);
    }

    public function UploadDefaultImage($pageShortName, $filename, $imageContentType = null)
    {
        $url = "fundraising/pages/" . $pageShortName . "/images/default";

        return $this->postFile($url, $filename, $imageContentType);
    }

    public function addImage($pageShortName, $addImageRequest)
    {
        return $this->put("fundraising/pages/" . $pageShortName . "/images", $addImageRequest);
    }

    public function getImages($pageShortName)
    {
        return $this->get("fundraising/pages/" . $pageShortName . "/images");
    }

    public function addVideo($pageShortName, $addVideoRequest)
    {
        return $this->put("fundraising/pages/" . $pageShortName . "/videos", $addVideoRequest);
    }

    public function getVideos($pageShortName)
    {
        return $this->get("fundraising/pages/" . $pageShortName . "/videos");
    }

    public function cancel($pageShortName)
    {
        return $this->delete("fundraising/pages/" . $pageShortName);
    }

}
