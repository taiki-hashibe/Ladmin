<?php

namespace LowB\Ladmin\Filter\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \LowB\Ladmin\Filter\LadminFilter
 */
class LadminFilter extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \LowB\Ladmin\Filter\LadminFilter::class;
    }
}
