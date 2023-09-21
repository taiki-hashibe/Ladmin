<?php

namespace LowB\Ladmin\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \LowB\Ladmin\Ladmin
 */
class Ladmin extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \LowB\Ladmin\Ladmin::class;
    }
}
