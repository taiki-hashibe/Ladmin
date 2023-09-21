<?php

namespace LowB\Ladmin\Route\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \LowB\Ladmin\Route\LadminRoute
 */
class LadminRoute extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \LowB\Ladmin\Route\LadminRoute::class;
    }
}
