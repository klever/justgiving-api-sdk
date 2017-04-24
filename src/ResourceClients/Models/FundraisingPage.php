<?php

namespace Klever\JustGivingApiSdk\ResourceClients\Models;

use Klever\JustGivingApiSdk\ResourceClients\Models\Assets\Theme;

class FundraisingPage extends Model
{

    public $reference;
    public $charityId;
    public $eventId;
    public $pageShortName;
    public $pageTitle;
    public $activityType;
    public $targetAmount;
    public $charityOptIn;
    public $eventDate;
    public $eventName;
    public $attribution;
    public $charityFunded;
    public $causeId;
    public $companyAppealId;
    public $expiryDate;
    public $pageStory;
    public $pageSummaryWhat;
    public $pageSummaryWhy;
    public $customCode;

    /** @var Theme */
    public $theme;

    /**
     * Array of Image objects.
     *
     * @var array
     */
    public $images = []; // new FundraisingPageImage;

    /**
     * Array of Video objects.
     *
     * @var array
     */
    public $videos = [];

    public $rememberedPersonReference;
    public $consistentErrorResponses = false;
    public $teamId;
    public $currency;

}
