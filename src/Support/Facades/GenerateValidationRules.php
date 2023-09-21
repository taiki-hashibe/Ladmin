<?php

namespace LowB\Ladmin\Support\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \LowB\Ladmin\Support\GenerateValidationRules
 */
class GenerateValidationRules extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \LowB\Ladmin\Support\GenerateValidationRules::class;
    }
}
