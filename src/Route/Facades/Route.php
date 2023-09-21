<?php

namespace LowB\Ladmin\Route\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \LowB\Ladmin\Route\Route
 */
class Route extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \LowB\Ladmin\Route\Route::class;
    }
}
