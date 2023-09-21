<?php

namespace LowB\Ladmin\Config;

class LadminConfig
{
    protected string $route = '/{table}/{crud}/{primaryKey}';
    protected bool $prefix = true;
    protected array $hiddenColumns = [
        'email_verified_at',
        'password',
        'remember_token',
    ];
    protected array $hiddenShow = [];
    protected array $hiddenDetail = [];
    protected array $hiddenEditor = [
        'id',
        'created_at',
        'updated_at'
    ];
    protected string $theme = 'ladmin::';
    protected string $localViewPrefix = 'admin.';

    public function route(?string $route = null): string
    {
        if ($route) {
            $this->route = $route;
        }
        return $this->route;
    }

    public function prefix(?bool $prefix = null): bool
    {
        if ($prefix) {
            $this->prefix = $prefix;
        }
        return $this->prefix;
    }

    public function hiddenColumns(?array $hiddenColumns = null): array
    {
        if ($hiddenColumns) {
            $this->hiddenColumns = $hiddenColumns;
        }
        return $this->hiddenColumns;
    }

    public function hiddenShow(?array $hiddenShow = null): array
    {
        if ($hiddenShow) {
            $this->hiddenShow = $hiddenShow;
        }
        return array_unique(array_merge($this->hiddenColumns, $this->hiddenShow));
    }

    public function hiddenDetail(?array $hiddenDetail = null): array
    {
        if ($hiddenDetail) {
            $this->hiddenDetail = $hiddenDetail;
        }
        return array_unique(array_merge($this->hiddenColumns, $this->hiddenDetail));
    }

    public function hiddenEditor(?array $hiddenEditor = null): array
    {
        if ($hiddenEditor) {
            $this->hiddenDetail = $hiddenEditor;
        }
        return array_unique(array_merge($this->hiddenColumns, $this->hiddenEditor));
    }

    public function theme(?string $theme = null): string
    {
        if ($theme) {
            $this->theme = $theme;
        }
        return $this->theme;
    }

    public function localViewPrefix(?string $prefix = null): string
    {
        if ($prefix) {
            $this->localViewPrefix = $prefix;
        }
        return $this->localViewPrefix;
    }
}
