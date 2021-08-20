<?php

namespace Emagia\Hero\Managers;

use Exception;

class CLIManager
{
    /**
     * @var string
     */
    const ACCEPTED_RESOURCE_TYPE = "stream";

    /**
     * @var resource
     */
    private $resource = null;

    /**
     * @var CLIManager
     */
    private static $instance = null;

    public function __construct()
    {
        $this->resource = fopen("php://stdin", "r");
    }

    /**
     * @return CLIManager
     */
    public static function getInstance(): CLIManager
    {
        if (self::$instance instanceof self === false) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * @return void
     */
    public function destroy(): void
    {
        fclose($this->resource);
    }

    /**
     * @return string
     *
     * @throws Exception
     */
    public function read(): string
    {
        $this->validateResource();

        return fgets($this->resource);
    }

    /**
     * @param string $input
     *
     * @return void
     *
     * @throws Exception
     */
    public function write(string $input): void
    {
        $this->validateResource();

        fwrite($this->resource, "{$input}\r\n");
    }

    /**
     * @return void
     *
     * @throws Exception
     */
    public function writeHeader(): void
    {
        $input = "";

        for ($i = 0; $i < 40; $i++) {
            $input .= "=";
        }

        $this->write($input);
    }

    /**
     * @return bool
     *
     * @throws Exception
     */
    private function validateResource(): bool
    {
        if (is_resource($this->resource) && get_resource_type($this->resource) === self::ACCEPTED_RESOURCE_TYPE) {
            return true;
        }

        throw new \Exception("Invalid resource.");
    }
}
