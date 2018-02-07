<?php

namespace Konsulting\JustGivingApiSdk\ResourceClients\Models;

class RegisterCampaignRequest extends Model
{
    public $campaignUrl;
    public $campaignName;
    public $campaignSummary;
    public $campaignStory;
    public $currencyCode;
    public $campaignTarget;
    public $campaignLogos;
    public $campaignCoverPhotos = [];
    public $campaignPhotos;
    public $campaignDeadline;
    public $campaignThankYouMessage;
    public $fundraisingEnabled;

}
