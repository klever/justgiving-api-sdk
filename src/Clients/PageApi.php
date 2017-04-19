<?php

namespace Klever\JustGivingApiSdk\Clients;

use Klever\JustGivingApiSdk\Clients\Models\StoryUpdateRequest;

class PageApi extends ClientBase
{
    public function Create($pageCreationRequest)
    {
        return $this->put("fundraising/pages", $pageCreationRequest);
    }

    public function IsShortNameRegistered($pageShortName)
    {
        return $this->head("fundraising/pages/" . $pageShortName)->existenceCheck();
    }

    public function ListAll()
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

    public function UploadImage($pageShortName, $caption, $filename, $imageContentType)
    {
        $url = "fundraising/pages/" . $pageShortName . "/images?caption=" . urlencode($caption);

        return $this->postFile($url, $filename, $imageContentType);
//        if ($httpInfo['http_code'] == 200) {
//            return true;
//        } else {
//            return false;
//        }

    }

    public function RetrieveDonationsForPageByReference($pageShortName, $reference, $privateData = false)
    {
        // TODO: check what privateData is used for
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
        )->existenceCheck();
    }

    public function AppendToFundraisingPageAttribution($pageShortName, $appendToFundraisingPageAttributionRequest)
    {
       return $this->post(
           "fundraising/pages/" . $pageShortName . "/attribution",
               $appendToFundraisingPageAttributionRequest
       )->existenceCheck();
    }

    public function GetFundraisingPageAttribution($pageShortName)
    {
        return $this->get("fundraising/pages/" . $pageShortName . "/attribution");
    }

    public function UploadDefaultImage($pageShortName, $filename, $imageContentType)
    {
        $fh = fopen($filename, 'r');
        $imageBytes = fread($fh, filesize($filename));
        fclose($fh);

        $url = "fundraising/pages/" . $pageShortName . "/images/default";

        $httpInfo = $this->httpClient->Post($url, $imageBytes, $imageContentType);

        if ($httpInfo['http_code'] == 200) {
            return true;
        } else {
            return $httpInfo;
        }
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
