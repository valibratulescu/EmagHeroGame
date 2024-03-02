<?php

namespace App\Exception;

use Exception;

class HeroMissingException extends Exception
{
    private const string MESSAGE = "The beast conquered Emagia. There was no hero to defend it.";

    public function __construct() {
        parent::__construct(static::MESSAGE);
    }
}