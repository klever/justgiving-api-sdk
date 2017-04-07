<?php

namespace Klever\JustGivingApiSdk\Clients\Models;

class RegisterCampaignRequest extends Model
{
    public $campaignUrl;
    public $campaignName;
    public $campaignSummary;
    public $campaignStory;
    public $currencyCode;
    public $campaignTarget;
    public $campaignLogos;
    public $campaignCoverPhotos;
    public $campaignPhotos;
    public $campaignDeadline;
    public $campaignThankYouMessage;
    public $fundraisingEnabled;
}

class CampaignCoverPhotos extends Model
{
    public $url;
    public $caption;
    public $title;
    public $alt;
}

class CampaignLogos extends Model
{
    public $url;
    public $caption;
    public $title;
    public $alt;
}

class CampaignPhotos extends Model
{
    public $url;
    public $caption;
    public $title;
    public $alt;
}
