<?php

namespace Hogus\LaravelEasemob\Exceptions;


class GatewayErrorException extends Exception
{
    public $raw = [];

    public function __construct($message, $code, $raw = [])
    {
        parent::__construct($message, $code);

        $this->raw = $raw;
    }
}
