<?php

namespace LowB\Ladmin\Config;

use Illuminate\Support\Arr;

class LadminConfig
{
    protected array $config = [];
    protected string $theme = 'ladmin';

    public function __construct()
    {
        $this->config = config('ladmin');
    }

    public function config(string $key)
    {
        return Arr::get($this->config, $key);
    }

    public function localView(string $view)
    {
        return $this->config('view.prefix') . "::$view";
    }

    public function themeView(string $view)
    {
        return "$this->theme::$view";
    }
}
