<?php

namespace LowB\Ladmin\Fields;

class BelongsTo extends FieldRenderer
{
    protected $belongsTo;

    public function __construct(string $columnName, string $belongsTo, string $view, string $type = null, int $order = null)
    {
        parent::__construct($columnName, $view, $type, $order);
        $this->belongsTo = $belongsTo;
    }

    public function getValue(mixed $model): mixed
    {
        return $model->{$this->columnName}->{$this->belongsTo};
    }
}
