<?php

namespace Klever\JustGivingApiSdk\Clients;

use Klever\JustGivingApiSdk\Clients\Models\StoryUpdateRequest;

class PageApi extends BaseClient
{
    public function RegisterFundraisingPage($pageCreationRequest)
    {
        return $this->put("fundraising/pages", $pageCreationRequest);
    }

    public function FundraisingPageUrlCheck($pageShortName)
    {
        return $this->head("fundraising/pages/" . $pageShortName);
    }

    public function GetFundraisingPages()
    {
        return $this->get("fundraising/pages");
    }

    public function Retrieve($pageShortName)
    {
        return $this->get("fundraising/pages/" . $pageShortName);
    }

    public function SuggestPageShortNames($preferredName)
    {
        return $this->get("fundraising/pages/suggest?preferredName=" . urlencode($preferredName));
    }

    public function RetrieveDonationsForPage($pageShortName, $pageSize = 50, $pageNumber = 1)
    {
        return $this->get("fundraising/pages/" . $pageShortName . "/donations" . "?PageSize=" . $pageSize . "&PageNum=" . $pageNumber);
    }

    public function UpdateStory($pageShortName, $storyUpdate)
    {
        $storyUpdateRequest = new StoryUpdateRequest();
        $storyUpdateRequest->storySupplement = $storyUpdate;

        return $this->post("fundraising/pages/" . $pageShortName, $storyUpdateRequest);
    }

    public function RetrieveDonationsForPageByReference($pageShortName, $reference)
    {
        return $this->get("fundraising/pages/" . $pageShortName . "/donations/ref/" . $reference);
    }

    public function GetPageUpdates($pageShortName)
    {
        return $this->get("fundraising/pages/" . $pageShortName . "/updates/");
    }

    public function GetPageUpdateById($pageShortName, $updateId)
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

    public function AddImage($pageShortName, $addImageRequest)
    {
        return $this->put("fundraising/pages/" . $pageShortName . "/images", $addImageRequest);
    }

    public function GetImages($pageShortName)
    {
        return $this->get("fundraising/pages/" . $pageShortName . "/images");
    }

    public function AddVideo($pageShortName, $addVideoRequest)
    {
        return $this->put("fundraising/pages/" . $pageShortName . "/videos", $addVideoRequest);
    }

    public function GetVideos($pageShortName)
    {
        return $this->get("fundraising/pages/" . $pageShortName . "/videos");
    }

    public function Cancel($pageShortName)
    {
        return $this->delete("fundraising/pages/" . $pageShortName);
    }

}
