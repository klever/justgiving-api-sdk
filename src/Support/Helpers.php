<?php

namespace Konsulting\JustGivingApiSdk\Support;

use Carbon\Carbon;
use DateTime;

class Helpers
{
    /**
     * Return a Carbon instance from a string or DateTime instance.
     *
     * @param string|DateTime|Carbon $date
     * @return Carbon
     */
    public static function dateToCarbon($date)
    {
        if ($date instanceof Carbon) {
            return $date;
        }

        if (is_string($date)) {
            return static::dateFromString($date);
        }

        if ($date instanceof DateTime) {
            return Carbon::parse($date->format('r'));
        }

        return null;
    }

    /**
     * Create a Carbon instance from a string. Can be in '/Date(1365004652303-0500)/' format or any other standard
     * format that Carbon will parse.
     *
     * @param string $date
     * @return Carbon
     */
    protected static function dateFromString($date)
    {
        preg_match('/(\d{10})(\d{3})([\+\-]\d{4})/', $date, $matches);

        if (count($matches) == 4) {
            return Carbon::createFromFormat("U.u.O", vsprintf('%2$s.%3$s.%4$s', $matches));
        }

        return Carbon::parse($date);
    }
}
