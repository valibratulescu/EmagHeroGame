<?php

namespace App\Exception;

use Exception;

class BeastMissingException extends Exception
{
    private const string MESSAGE = "Emagia is safe, there is no monster to threaten it.";

    public function __construct() {
        parent::__construct(static::MESSAGE);
    }
}