<?php

namespace AdrianMejias\ZipBomb\Exceptions;

use Exception;

class InvalidConfiguration extends Exception
{
    public static function agentsNotSpecified()
    {
        return new static('No agents specified. You must provide at least 1 agent to check against.');
    }

    public static function pathsNotSpecified()
    {
        return new static('No paths specified. You must provide at least 1 path to check against.');
    }

    public static function zipBombFileNotWriteable(string $path)
    {
        return new static("Could not create a zip bomb file at `{$path}`.");
    }

    public static function zipBombFileDoesNotExist(string $path)
    {
        return new static("Could not find a zip bomb file at `{$path}`.");
    }
}