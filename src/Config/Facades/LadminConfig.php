<?php

namespace LowB\Ladmin\Config\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \LowB\Ladmin\Config\LadminConfig
 */
class LadminConfig extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \LowB\Ladmin\Config\LadminConfig::class;
    }
}
