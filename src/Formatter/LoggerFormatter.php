<?php

namespace App\Formatter;

use Monolog\Formatter\LineFormatter;
use Monolog\LogRecord;

class LoggerFormatter extends LineFormatter
{
    public function format(LogRecord $record): string
    {
        return $record->message . PHP_EOL;
    }
}