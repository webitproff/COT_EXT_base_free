<?php

namespace _PhpScoper5d8cb17438769\GuzzleHttp\Exception;

use _PhpScoper5d8cb17438769\Psr\Http\Message\RequestInterface;
use _PhpScoper5d8cb17438769\Psr\Http\Message\ResponseInterface;
/**
 * Exception when an HTTP error occurs (4xx or 5xx error)
 */
class BadResponseException extends \_PhpScoper5d8cb17438769\GuzzleHttp\Exception\RequestException
{
    public function __construct($message, \_PhpScoper5d8cb17438769\Psr\Http\Message\RequestInterface $request, \_PhpScoper5d8cb17438769\Psr\Http\Message\ResponseInterface $response = null, \Exception $previous = null, array $handlerContext = [])
    {
        if (null === $response) {
            @\trigger_error('Instantiating the ' . __CLASS__ . ' class without a Response is deprecated since version 6.3 and will be removed in 7.0.', \E_USER_DEPRECATED);
        }
        parent::__construct($message, $request, $response, $previous, $handlerContext);
    }
}
