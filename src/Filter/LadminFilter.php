<?php

namespace LowB\Ladmin\Filter;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Route;
use LowB\Ladmin\Support\LadminFilter as SupportLadminFilter;

class LadminFilter
{
    public array $params = [];

    public function __construct()
    {
        $this->params = request()->all();
    }

    public function except(array|string $key): self
    {
        $this->params = Arr::except($this->params, Arr::wrap($key));

        return $this;
    }

    private function getInputElm(string $name, string $value)
    {
        return "<input type='hidden' name='$name' value='$value'>";
    }

    public function render()
    {
        foreach ($this->params as $key => $param) {
            if ($key === 'page') {
                continue;
            }
            if (is_array($param) && $key === SupportLadminFilter::ORDER) {
                foreach ($param as $orderParamKey => $orderParam) {
                    echo $this->getInputElm("$key".'['.$orderParamKey.']', $orderParam);
                }
            } elseif ($key === SupportLadminFilter::KEYWORD) {
                echo $this->getInputElm($key, $param);
            } else {
                echo $this->getInputElm($key, $param);
            }
        }
    }

    public function url()
    {
        return route(Route::currentRouteName(), $this->params);
    }
}
