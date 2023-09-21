<?php

namespace LowB\Ladmin\Support\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \LowB\Ladmin\Support\LadminRoute
 */
class LadminRoute extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \LowB\Ladmin\Support\LadminRoute::class;
    }
}
