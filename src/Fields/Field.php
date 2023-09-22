<?php

namespace LowB\Ladmin\Fields;

abstract class Field
{
    protected static string $view = 'fields.default';

    public static function column(string $columnName, string $type = null, ?int $order = null): Column
    {
        return new Column($columnName, static::$view, $type, $order);
    }

    public static function belongsTo(string $columnName, string $belongsTo, string $type = null, ?int $order = null): BelongsTo
    {
        return new BelongsTo($columnName, $belongsTo, static::$view, $type, $order);
    }
}
