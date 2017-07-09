<?php

namespace AdrianMejias\ZipBomb;

use Illuminate\Support\Facades\Facade;

class ZipBombFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'zipbomb';
    }
}
