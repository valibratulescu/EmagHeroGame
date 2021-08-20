<?php

namespace Emagia\Hero\Utils;

class AutoloaderUtils
{
    /**
     * Builds the path for a specific class based on the project namespace.
     *
     * @param string $class
     *
     * @return string
     */
    public static function buildClassFilePath(string $class): string
    {
        return getcwd() . "/{$class}.php";
    }

    /**
     * Builds the full namespace path.
     *
     * @param string $class
     *
     * @return string
     */
    public static function buildNamespaceFromParts(array $extraParts): string
    {
        $namespaceParts = explode("\\", __NAMESPACE__);

        $namespaceParts = array_slice($namespaceParts, 0, 2);

        $namespaceParts = array_merge($namespaceParts, $extraParts);

        return implode("\\", $namespaceParts);
    }
}
