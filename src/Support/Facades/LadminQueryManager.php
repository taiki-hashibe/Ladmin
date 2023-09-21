<?php

namespace LowB\Ladmin\Support\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \LowB\Ladmin\Support\Query\LadminQueryManager
 */
class LadminQueryManager extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \LowB\Ladmin\Support\Query\LadminQueryManager::class;
    }
}
