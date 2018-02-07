<?php

namespace Konsulting\JustGivingApiSdk\ResourceClients\Models\Assets;

use Konsulting\JustGivingApiSdk\ResourceClients\Models\Model;

class Image extends Model
{
    /** @var string */
    public $url;

    /** @var string */
    public $caption;

    /** @var string */
    public $title;

    /** @var string */
    public $alt;

    /** @var bool */
    public $isDefault;
}
