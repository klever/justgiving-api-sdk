<?php namespace Klever\JustGivingApiSdk\Clients;

//include_once 'ClientBase.php';
//include_once 'Http/CurlWrapper.php';
//include_once 'Model/RegisterPageRequest.php';
//include_once 'Model/StoryUpdateRequest.php';

use Klever\JustGivingApiSdk\Clients\Http\HTTPResponse;
use Klever\JustGivingApiSdk\Clients\Models\StoryUpdateRequest;

class PageApi extends ClientBase
{


    public function CreateV2($pageCreationRequest)
    {
        $httpResponse = new HTTPResponse();
        $locationFormat = $this->Parent->baseUrl() . "fundraising/pages";
        $url = $this->BuildUrl($locationFormat);
        $payload = json_encode($pageCreationRequest);
        $result = $this->curlWrapper->PutV2($url, $this->BuildAuthenticationValue(), $payload);
        $httpResponse->bodyResponse = json_decode($result->bodyResponse);
        $httpResponse->httpStatusCode = $result->httpStatusCode;

        return $httpResponse;
    }

    public function Create($pageCreationRequest)
    {
        $locationFormat = $this->Parent->baseUrl() . "fundraising/pages";
        $url = $this->BuildUrl($locationFormat);
        $payload = json_encode($pageCreationRequest);
        $json = $this->curlWrapper->Put($url, $this->BuildAuthenticationValue(), $payload);

        return json_decode($json);
    }

    public function IsShortNameRegisteredV2($pageShortName)
    {
        $httpResponse = new HTTPResponse();
        $locationFormat = $this->Parent->baseUrl() . "fundraising/pages/" . $pageShortName;
        $url = $this->BuildUrl($locationFormat);
        $result = $this->curlWrapper->HeadV2($url, $this->BuildAuthenticationValue());
        $httpResponse->bodyResponse = json_decode($result->bodyResponse);
        $httpResponse->httpStatusCode = $result->httpStatusCode;

        return $httpResponse;
    }

    public function IsShortNameRegistered($pageShortName)
    {
        $locationFormat = $this->Parent->baseUrl() . "fundraising/pages/" . $pageShortName;
        $url = $this->BuildUrl($locationFormat);
        $httpInfo = $this->curlWrapper->Head($url, $this->BuildAuthenticationValue());

        if ($httpInfo['http_code'] == 200) {
            return true;
        } else {
            return false;
        }
    }

    public function ListAll()
    {
        $locationFormat = $this->Parent->baseUrl() . "fundraising/pages";
        $url = $this->BuildUrl($locationFormat);
        $json = $this->curlWrapper->Get($url, $this->BuildAuthenticationValue());

        return json_decode($json);
    }

    public function Retrieve($pageShortName)
    {
        $locationFormat = $this->Parent->baseUrl() . "fundraising/pages/" . $pageShortName;
        $url = $this->BuildUrl($locationFormat);
        $json = $this->curlWrapper->Get($url, $this->BuildAuthenticationValue());

        return json_decode($json);
    }

    public function SuggestPageShortNames($preferredName)
    {
        $locationFormat = $this->Parent->baseUrl() . "fundraising/pages/suggest?preferredName=" . urlencode($preferredName);
        $url = $this->BuildUrl($locationFormat);
        $json = $this->curlWrapper->Get($url, $this->BuildAuthenticationValue());

        return json_decode($json);
    }

    public function RetrieveDonationsForPage($pageShortName, $pageSize = 50, $pageNumber = 1)
    {
        $locationFormat = $this->Parent->baseUrl() . "fundraising/pages/" . $pageShortName . "/donations" . "?PageSize=" . $pageSize . "&PageNum=" . $pageNumber;
        $url = $this->BuildUrl($locationFormat);
        $json = $this->curlWrapper->Get($url, $this->BuildAuthenticationValue());

        return json_decode($json);
    }

    public function UpdateStory($pageShortName, $storyUpdate)
    {
        $locationFormat = $this->Parent->baseUrl() . "fundraising/pages/" . $pageShortName;
        $url = $this->BuildUrl($locationFormat);
        $storyUpdateRequest = new StoryUpdateRequest();
        $storyUpdateRequest->storySupplement = $storyUpdate;
        $payload = json_encode($storyUpdateRequest);
        $httpInfo = $this->curlWrapper->Post($url, $this->BuildAuthenticationValue(), $payload);

        return $httpInfo['http_code'] == 200;
    }

    public function UploadImage($pageShortName, $caption, $filename, $imageContentType)
    {
        $locationFormat = $this->Parent->baseUrl() . "fundraising/pages/" . $pageShortName . "/images?caption=" . urlencode($caption);
        $url = $this->BuildUrl($locationFormat);
        $httpInfo = $this->curlWrapper->PostBinary($url, $this->BuildAuthenticationValue(), $filename, $imageContentType);
        if ($httpInfo['http_code'] == 200) {
            return true;
        } else {
            return false;
        }

    }

    public function RetrieveDonationsForPageByReference($pageShortName, $reference, $privateData = false)
    {
        $locationFormat = $this->Parent->baseUrl() . "fundraising/pages/" . $pageShortName . "/donations/ref/" . $reference;
        $url = $this->BuildUrl($locationFormat);
        if ($privateData == 1) {
            $json = $this->curlWrapper->Get($url);
        } else {
            $json = $this->curlWrapper->Get($url, $this->BuildAuthenticationValue());
        }

        return json_decode($json);
    }

    public function GetPageUpdates($pageShortName)
    {
        $locationFormat = $this->Parent->baseUrl() . "fundraising/pages/" . $pageShortName . "/updates/";
        $url = $this->BuildUrl($locationFormat);
        $json = $this->curlWrapper->Get($url);

        return json_decode($json);
    }

    public function GetPageUpdateById($pageShortName, $updateId)
    {
        $locationFormat = $this->Parent->baseUrl() . "fundraising/pages/" . $pageShortName . "/updates/" . $updateId;
        $url = $this->BuildUrl($locationFormat);
        $json = $this->curlWrapper->Get($url);

        return json_decode($json);
    }

    public function AddPostToPageUpdate($pageShortName, $addPostToPageUpdateRequest)
    {
        $locationFormat = $this->Parent->baseUrl() . "fundraising/pages/" . $pageShortName . "/updates/";
        $url = $this->BuildUrl($locationFormat);
        $payload = json_encode($addPostToPageUpdateRequest);
        $json = $this->curlWrapper->PostAndGetResponse($url, $this->BuildAuthenticationValue(), $payload);

        return json_decode($json);
    }

    public function DeleteFundraisingPageAttribution($pageShortName)
    {
        $locationFormat = $this->Parent->baseUrl() . "fundraising/pages/" . $pageShortName . "/attribution";
        $url = $this->BuildUrl($locationFormat);
        $json = $this->curlWrapper->Delete($url, $this->BuildAuthenticationValue());
        if ($json['http_code'] == 200) {
            return true;
        } else if ($json['http_code'] == 404) {
            return false;
        }
    }

    public function UpdateFundraisingPageAttribution($pageShortName, $updateFundraisingPageAttributionRequest)
    {
        $requestBody = $updateFundraisingPageAttributionRequest;
        $locationFormat = $this->Parent->baseUrl() . "fundraising/pages/" . $pageShortName . "/attribution";
        $url = $this->BuildUrl($locationFormat);
        $payload = json_encode($requestBody);
        $json = $this->curlWrapper->Put($url, $this->BuildAuthenticationValue(), $payload, true);
        if ($json['http_code'] == 200) {
            return true;
        } else if ($json['http_code'] == 404) {
            return false;
        }
    }

    public function AppendToFundraisingPageAttribution($pageShortName, $appendToFundraisingPageAttributionRequest)
    {
        $requestBody = $appendToFundraisingPageAttributionRequest;
        $locationFormat = $this->Parent->baseUrl() . "fundraising/pages/" . $pageShortName . "/attribution";
        $url = $this->BuildUrl($locationFormat);
        $payload = json_encode($requestBody);
        $json = $this->curlWrapper->Post($url, $this->BuildAuthenticationValue(), $payload);
        if ($json['http_code'] == 200) {
            return true;
        } else if ($json['http_code'] == 404) {
            return false;
        }
    }

    public function GetFundraisingPageAttribution($pageShortName)
    {
        $locationFormat = $this->Parent->baseUrl() . "fundraising/pages/" . $pageShortName . "/attribution";
        $url = $this->BuildUrl($locationFormat);
        $json = $this->curlWrapper->Get($url);

        return json_decode($json);
    }

    public function UploadDefaultImage($pageShortName, $filename, $imageContentType)
    {
        $fh = fopen($filename, 'r');
        $imageBytes = fread($fh, filesize($filename));
        fclose($fh);

        $locationFormat = $this->Parent->baseUrl() . "fundraising/pages/" . $pageShortName . "/images/default";
        $url = $this->BuildUrl($locationFormat);
        $httpInfo = $this->curlWrapper->Post($url, $this->BuildAuthenticationValue(), $imageBytes, $imageContentType);

        if ($httpInfo['http_code'] == 200) {
            return true;
        } else {
            return $httpInfo;
        }
    }

    public function AddImage($pageShortName, $addImageRequest)
    {
        $locationFormat = $this->Parent->baseUrl() . "fundraising/pages/" . $pageShortName . "/images";
        $url = $this->BuildUrl($locationFormat);
        $payload = json_encode($addImageRequest);
        $json = $this->curlWrapper->Put($url, $this->BuildAuthenticationValue(), $payload);

        return json_decode($json);
    }

    public function GetImages($pageShortName)
    {
        $locationFormat = $this->Parent->baseUrl() . "fundraising/pages/" . $pageShortName . "/images";
        $url = $this->BuildUrl($locationFormat);
        $json = $this->curlWrapper->Get($url);

        return json_decode($json);
    }

    public function AddVideo($pageShortName, $addVideoRequest)
    {
        $locationFormat = $this->Parent->baseUrl() . "fundraising/pages/" . $pageShortName . "/videos";
        $url = $this->BuildUrl($locationFormat);
        $payload = json_encode($addVideoRequest);
        $json = $this->curlWrapper->Put($url, $this->BuildAuthenticationValue(), $payload);

        return json_decode($json);
    }

    public function GetVideos($pageShortName)
    {
        $locationFormat = $this->Parent->baseUrl() . "fundraising/pages/" . $pageShortName . "/videos";
        $url = $this->BuildUrl($locationFormat);
        $json = $this->curlWrapper->Get($url);

        return json_decode($json);
    }

    public function Cancel($pageShortName)
    {
        $locationFormat = $this->Parent->baseUrl() . "fundraising/pages/" . $pageShortName;
        $url = $this->BuildUrl($locationFormat);
        $httpInfo = $this->curlWrapper->Delete($url, $this->BuildAuthenticationValue());

        return $httpInfo;
    }

}
