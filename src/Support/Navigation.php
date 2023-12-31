<?php

namespace LowB\Ladmin\Support;

use Illuminate\Contracts\View\View as ContractsView;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use LowB\Ladmin\Config\Facades\LadminConfig;
use LowB\Ladmin\Contracts\Renderable;
use LowB\Ladmin\Route\Facades\LadminRoute;

class Navigation implements Renderable
{
    public string $label;

    public string $uri;

    public string $routeName;

    public ?string $name;

    public string $view = 'navigation.default';

    public ?int $order = null;

    public function __construct(string $label, string $uri, string $routeName, string $name = null, string $view = null, int $order = null)
    {
        $this->label = $label;
        $this->uri = $uri;
        $this->routeName = $routeName;
        $this->name = $name;
        if ($view) {
            $this->view = $view;
        }
        $this->order = $order;
    }

    public function setView(string $view): self
    {
        $this->view = $view;

        return $this;
    }

    public function isActive(): bool
    {
        $currentRoute = LadminRoute::getCurrentRoute();
        if (! $currentRoute) {
            return false;
        }

        return $this->routeName === $currentRoute->route->action['as'];
    }

    public function getOrder(): ?int
    {
        return $this->order;
    }

    public function toArray()
    {
        return [
            'label' => $this->label,
            'uri' => $this->uri,
            'routeName' => $this->routeName,
            'name' => $this->name,
            'order' => $this->order,
        ];
    }

    public function render(mixed $params = []): ContractsView
    {
        return View::first([
            LadminConfig::localView(Str::of($this->view)->replace('default', $this->name)),
            LadminConfig::localView($this->view),
            LadminConfig::themeView(Str::of($this->view)->replace('default', $this->name)),
            LadminConfig::themeView($this->view),
        ], [
            'navigation' => $this,
            'params' => $params,
        ]);
    }
}
