<?php

namespace App\Services\Map\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class Map
 * @package App\Services\Map\Facades
 */
class Map extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'map';
    }
}
