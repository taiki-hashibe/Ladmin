<?php

namespace LowB\Ladmin\Support\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \LowB\Ladmin\Support\GenerateFields
 */
class GenerateFields extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \LowB\Ladmin\Support\GenerateFields::class;
    }
}
