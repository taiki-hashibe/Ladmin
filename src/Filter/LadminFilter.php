<?php

namespace LowB\Ladmin\Filter;

use Illuminate\Support\Arr;

class LadminFilter
{
    public array $params = [];

    public function test()
    {
        dump(1);
    }

    public function __construct()
    {
        $this->params = request()->all();
    }

    public function except(array $key): self
    {
        $this->params = Arr::except($this->params, $key);

        return $this;
    }
}
