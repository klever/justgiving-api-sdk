<?php namespace Klever\JustGivingApiSdk\Clients;

use Klever\JustGivingApiSdk\Clients\Http\CurlWrapper;

include_once 'ClientBase.php';
include_once 'Http/CurlWrapper.php';

class ProjectApi extends ClientBase
{

    public $Parent;
    public $curlWrapper;

    public function __construct($justGivingApi)
    {
        $this->Parent = $justGivingApi;
        $this->curlWrapper = new CurlWrapper();
    }

    public function Projects($searchTerm)
    {
        $locationFormat = $this->Parent->baseUrl() . "project?q=" . $searchTerm;
        $url = $this->BuildUrl($locationFormat);
        $json = $this->curlWrapper->Get($url);

        return json_decode($json);
    }

    public function GetProject($projectId)
    {
        $locationFormat = $this->Parent->baseUrl() . "project/global/" . $projectId;
        $url = $this->BuildUrl($locationFormat);
        $json = $this->curlWrapper->Get($url);

        return json_decode($json);
    }
}
