<?php

namespace Konsulting\JustGivingApiSdk\Exceptions;

use Throwable;

class ClassNotFoundException extends \Exception
{
    public function __construct($class = '', $code = 0, Throwable $previous = null)
    {
        parent::__construct("Class {$class} not found.", $code, $previous);
    }
}
