<?php

namespace Klever\JustGivingApiSdk\Clients;

use Klever\JustGivingApiSdk\Clients\Http\HTTPResponse;
use Klever\JustGivingApiSdk\Clients\Models\StoryUpdateRequest;

class PageApi extends ClientBase
{
    public function CreateV2($pageCreationRequest)
    {
        $httpResponse = new HTTPResponse();
        $url = "fundraising/pages";

        $payload = json_encode($pageCreationRequest);
        $result = $this->curlWrapper->PutV2($url, $payload);
        $httpResponse->bodyResponse = json_decode($result->bodyResponse);
        $httpResponse->httpStatusCode = $result->httpStatusCode;

        return $httpResponse;
    }

    public function Create($pageCreationRequest)
    {
        $url = "fundraising/pages";

        $payload = json_encode($pageCreationRequest);
        $json = $this->curlWrapper->Put($url, $payload);

        return json_decode($json);
    }

    public function IsShortNameRegisteredV2($pageShortName)
    {
        $httpResponse = new HTTPResponse();
        $url = "fundraising/pages/" . $pageShortName;

        $result = $this->curlWrapper->HeadV2($url);
        $httpResponse->bodyResponse = json_decode($result->bodyResponse);
        $httpResponse->httpStatusCode = $result->httpStatusCode;

        return $httpResponse;
    }

    public function IsShortNameRegistered($pageShortName)
    {
        $url = "fundraising/pages/" . $pageShortName;

        $httpInfo = $this->curlWrapper->Head($url);

        if ($httpInfo['http_code'] == 200) {
            return true;
        } else {
            return false;
        }
    }

    public function ListAll()
    {
        $url = "fundraising/pages";

        $json = $this->getContent($url);

        return json_decode($json);
    }

    public function Retrieve($pageShortName)
    {
        $url = "fundraising/pages/" . $pageShortName;

        $json = $this->getContent($url);

        return json_decode($json);
    }

    public function SuggestPageShortNames($preferredName)
    {
        $url = "fundraising/pages/suggest?preferredName=" . urlencode($preferredName);

        $json = $this->getContent($url);

        return json_decode($json);
    }

    public function RetrieveDonationsForPage($pageShortName, $pageSize = 50, $pageNumber = 1)
    {
        $url = "fundraising/pages/" . $pageShortName . "/donations" . "?PageSize=" . $pageSize . "&PageNum=" . $pageNumber;

        $json = $this->getContent($url);

        return json_decode($json);
    }

    public function UpdateStory($pageShortName, $storyUpdate)
    {
        $url = "fundraising/pages/" . $pageShortName;

        $storyUpdateRequest = new StoryUpdateRequest();
        $storyUpdateRequest->storySupplement = $storyUpdate;
        $payload = json_encode($storyUpdateRequest);
        $httpInfo = $this->curlWrapper->Post($url, $payload);

        return $httpInfo['http_code'] == 200;
    }

    public function UploadImage($pageShortName, $caption, $filename, $imageContentType)
    {
        $url = "fundraising/pages/" . $pageShortName . "/images?caption=" . urlencode($caption);

        $httpInfo = $this->curlWrapper->PostBinary($url, $filename, $imageContentType);
        if ($httpInfo['http_code'] == 200) {
            return true;
        } else {
            return false;
        }

    }

    public function RetrieveDonationsForPageByReference($pageShortName, $reference, $privateData = false)
    {
        $url = "fundraising/pages/" . $pageShortName . "/donations/ref/" . $reference;

        if ($privateData == 1) {
            $json = $this->getContent($url);
        } else {
            $json = $this->getContent($url);
        }

        return json_decode($json);
    }

    public function GetPageUpdates($pageShortName)
    {
        $url = "fundraising/pages/" . $pageShortName . "/updates/";

        $json = $this->getContent($url);

        return json_decode($json);
    }

    public function GetPageUpdateById($pageShortName, $updateId)
    {
        $url = "fundraising/pages/" . $pageShortName . "/updates/" . $updateId;

        $json = $this->getContent($url);

        return json_decode($json);
    }

    public function AddPostToPageUpdate($pageShortName, $addPostToPageUpdateRequest)
    {
        $url = "fundraising/pages/" . $pageShortName . "/updates/";

        $payload = json_encode($addPostToPageUpdateRequest);
        $json = $this->curlWrapper->PostAndGetResponse($url, $payload);

        return json_decode($json);
    }

    public function DeleteFundraisingPageAttribution($pageShortName)
    {
        $url = "fundraising/pages/" . $pageShortName . "/attribution";

        $json = $this->curlWrapper->Delete($url);
        if ($json['http_code'] == 200) {
            return true;
        } else if ($json['http_code'] == 404) {
            return false;
        }
    }

    public function UpdateFundraisingPageAttribution($pageShortName, $updateFundraisingPageAttributionRequest)
    {
        $requestBody = $updateFundraisingPageAttributionRequest;
        $url = "fundraising/pages/" . $pageShortName . "/attribution";

        $payload = json_encode($requestBody);
        $json = $this->curlWrapper->Put($url, $payload, true);
        if ($json['http_code'] == 200) {
            return true;
        } else if ($json['http_code'] == 404) {
            return false;
        }
    }

    public function AppendToFundraisingPageAttribution($pageShortName, $appendToFundraisingPageAttributionRequest)
    {
        $requestBody = $appendToFundraisingPageAttributionRequest;
        $url = "fundraising/pages/" . $pageShortName . "/attribution";

        $payload = json_encode($requestBody);
        $json = $this->curlWrapper->Post($url, $payload);
        if ($json['http_code'] == 200) {
            return true;
        } else if ($json['http_code'] == 404) {
            return false;
        }
    }

    public function GetFundraisingPageAttribution($pageShortName)
    {
        $url = "fundraising/pages/" . $pageShortName . "/attribution";

        $json = $this->getContent($url);

        return json_decode($json);
    }

    public function UploadDefaultImage($pageShortName, $filename, $imageContentType)
    {
        $fh = fopen($filename, 'r');
        $imageBytes = fread($fh, filesize($filename));
        fclose($fh);

        $url = "fundraising/pages/" . $pageShortName . "/images/default";

        $httpInfo = $this->curlWrapper->Post($url, $imageBytes, $imageContentType);

        if ($httpInfo['http_code'] == 200) {
            return true;
        } else {
            return $httpInfo;
        }
    }

    public function AddImage($pageShortName, $addImageRequest)
    {
        $url = "fundraising/pages/" . $pageShortName . "/images";

        $payload = json_encode($addImageRequest);
        $json = $this->curlWrapper->Put($url, $payload);

        return json_decode($json);
    }

    public function GetImages($pageShortName)
    {
        $url = "fundraising/pages/" . $pageShortName . "/images";

        $json = $this->getContent($url);

        return json_decode($json);
    }

    public function AddVideo($pageShortName, $addVideoRequest)
    {
        $url = "fundraising/pages/" . $pageShortName . "/videos";

        $payload = json_encode($addVideoRequest);
        $json = $this->curlWrapper->Put($url, $payload);

        return json_decode($json);
    }

    public function GetVideos($pageShortName)
    {
        $url = "fundraising/pages/" . $pageShortName . "/videos";

        $json = $this->getContent($url);

        return json_decode($json);
    }

    public function Cancel($pageShortName)
    {
        $url = "fundraising/pages/" . $pageShortName;

        $httpInfo = $this->curlWrapper->Delete($url);

        return $httpInfo;
    }

}
