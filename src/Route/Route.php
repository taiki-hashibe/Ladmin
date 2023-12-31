<?php

namespace LowB\Ladmin\Route;

use Illuminate\Support\Facades\Route as FacadesRoute;
use LowB\Ladmin\Support\Navigation;

class Route
{
    protected mixed $route = null;

    protected string $label = '';

    protected ?string $crudAction = null;

    protected ?string $groupName = null;

    protected ?string $tableName = null;

    protected array $navigation = [];

    protected ?int $navigationOrder = null;

    public static function make(): self
    {
        return new self;
    }

    public function __call($method, $args): self
    {
        if ($this->route) {
            $this->route->{$method}(...$args);
        } else {
            $this->route = FacadesRoute::{$method}(...$args);
        }

        return $this;
    }

    public function getRoute(): mixed
    {
        return $this->route;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function setCrudAction(string $crudAction): self
    {
        $this->crudAction = $crudAction;

        return $this;
    }

    public function getCrudAction(): ?string
    {
        return $this->crudAction;
    }

    public function setGroupName(string $groupName): self
    {
        $this->groupName = $groupName;

        return $this;
    }

    public function getGroupName(): ?string
    {
        return $this->groupName;
    }

    public function setTableName(string $tableName): self
    {
        $this->tableName = $tableName;

        return $this;
    }

    public function getTableName(): ?string
    {
        return $this->tableName;
    }

    public function setNavigation(array $navigation): self
    {
        $this->navigation = $navigation;

        return $this;
    }

    public function addNavigation(string $navigation): self
    {
        $this->navigation[] = $navigation;

        return $this;
    }

    public function getNavigation(): array
    {
        return $this->navigation;
    }

    public function setNavigationOrder(int $num): self
    {
        $this->navigationOrder = $num;

        return $this;
    }

    public function getNavigationOrder(): int
    {
        return $this->navigationOrder;
    }

    public function toNavigation(string $name = null, self $route = null)
    {
        if (! $route) {
            $route = $this;
        }

        return new Navigation($this->label, $this->route->uri, $this->route->action['as'], $name, null, $this->navigationOrder);
    }
}
