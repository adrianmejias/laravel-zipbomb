<?php

namespace AdrianMejias\ZipBomb;

use Illuminate\Support\Facades\Facade;

/**
 * @see \AdrianMejias\ZipBomb\ZipBomb
 */
class ZipBombFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'laravel-zipbomb';
    }
}
