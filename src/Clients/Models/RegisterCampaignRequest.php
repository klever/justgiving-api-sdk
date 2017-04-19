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

    public function __construct($data = null)
    {
        $this->campaignCoverPhotos = new Image;
        $this->campaignLogos = new Image;
        $this->campaignPhotos = new Image;

        parent::__construct($data);
    }
}
