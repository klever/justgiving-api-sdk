<?php

namespace Konsulting\JustGivingApiSdk\Exceptions;

use Psr\Http\Message\ResponseInterface;
use Throwable;

class UnexpectedStatusException extends \Exception
{
    public function __construct(ResponseInterface $response, $code = 0, Throwable $previous = null)
    {
        parent::__construct('Unexpected status code returned: ' . $response->getStatusCode(), $code, $previous);
    }

}
