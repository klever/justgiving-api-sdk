<?php

namespace Klever\JustGivingApiSdk\Clients\Models;

class RegisterPageRequest extends Model
{
    public $reference;
    public $charityId;
    public $eventId;
    public $pageShortName;
    public $pageTitle;
    public $activityType;
    public $targetAmount;
    public $justGivingOptIn;
    public $charityOptIn;
    public $eventDate;
    public $eventName;
    public $attribution;
    public $charityFunded;
    public $causeId;
    public $images;
    public $videos;
}

class PageImage extends Model
{
    public $url;
    public $caption;
    public $isDefault;
}

class PageVideo extends Model
{
    public $url;
    public $caption;
}
