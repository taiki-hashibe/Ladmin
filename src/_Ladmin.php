<?php

namespace LowB\Ladmin;

use Illuminate\Contracts\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Request;
use LowB\Ladmin\Crud\Crud;

class Ladmin
{
    public array $crudList = [];
    protected array $routes = [];
    protected array $routeNames = [];

    public function addRoute(string $route): void
    {
        $this->routes[] = $route;
        $this->routes = array_unique($this->routes);
    }

    public function getRoutes(): array
    {
        return $this->routes;
    }

    public function addRouteName(string $routeName): void
    {
        $this->routeNames[] = $routeName;
        $this->routeNames = array_unique($this->routeNames);
    }

    public function getRouteNames(): array
    {
        return $this->routeNames;
    }

    public function crud(?string $name = null): Crud|null
    {
        if ($name) {
            foreach ($this->crudList as $crud) {
                if ($crud->name() === $name) {
                    return $crud;
                }
            }
        }
        foreach ($this->crudList as $crud) {
            if (Request::routeIs($crud->routeName())) {
                return $crud;
            }
        }
        return null;
    }

    public function crudFindByTableName(string $name): array
    {
        $result = [];
        foreach ($this->crudList as $crud) {
            if ($crud->tableName() === $name) {
                $result[] = $crud;
            }
        }
        return $result;
    }

    public function crudRegister(Crud $crud): void
    {
        $this->crudList[] = $crud;
        $this->addRoute($crud->route());
        $this->addRouteName($crud->routeName());
    }

    public function navigation(string|null $key = null): array
    {
        if (!$key) {
            return $this->crudList;
        }
        $navigation = [];
        foreach ($this->crudList as $crud) {
            if (in_array($key, $crud->navigation())) {
                $navigation[] = $crud;
            }
        }
        return $navigation;
    }

    public function query(): Model|QueryBuilder|null
    {
        return $this->crud()->query();
    }

    public function currentPrimaryKey(): string|null
    {
        if (!request()->primaryKey) {
            return null;
        };
        $primaryKey = request()->primaryKey;
        return $primaryKey;
    }

    public function currentItem(): mixed
    {
        if (!request()->primaryKey) {
            return null;
        };
        $primaryKey = request()->primaryKey;
        $query = $this->query();
        if ($query instanceof Model) {
            return $query->where($this->crud()->primaryKey(), $primaryKey)->first();
        }
        if ($query instanceof Builder) {
            return $query->where($this->crud()->primaryKey(), $primaryKey)->first();
        }
        return null;
    }

    public function currentItemKey(): mixed
    {
        $currentItem = $this->currentItem();
        if (!$currentItem) {
            return null;
        }
        return $currentItem->{$this->crud()->primaryKey()};
    }

    public function currentItemUpdate(mixed $values): mixed
    {
        if (!request()->primaryKey) {
            return null;
        };
        $primaryKey = request()->primaryKey;
        $query = $this->query();
        if ($query instanceof Model) {
            return $query->where($this->crud()->primaryKey(), $primaryKey)->first()->update($values);
        }
        if ($query instanceof Builder) {
            return $query->where($this->crud()->primaryKey(), $primaryKey)->update($values);
        }
        return null;
    }

    public function itemDelete(mixed $primaryKey): mixed
    {
        $query = $this->query();
        if ($query instanceof Model) {
            return $query->where($this->crud()->primaryKey(), $primaryKey)->first()->delete();
        }
        if ($query instanceof Builder) {
            return $query->where($this->crud()->primaryKey(), $primaryKey)->delete();
        }
        return null;
    }

    public function index(): Crud|null
    {
        if (config('ladmin.index')) {
            return config('ladmin.index');
        }
        $crudList = [];
        foreach ($this->crudList as $crud) {
            $crudList[] = $crud->toArray();
        }
        if (in_array(config('ladmin.route.dashboard'), array_column($crudList, 'tableName'))) {
            return $this->crudFindByTableName(config('ladmin.route.dashboard'));
        };
        if (in_array(config('ladmin.route.profile'), array_column($crudList, 'tableName'))) {
            return $this->crudFindByTableName(config('ladmin.route.profile'));
        }

        foreach ($this->crudList as $crud) {
            if ($crud->name() !== config('ladmin.route.login') && $crud->name() !== config('ladmin.route.logout') && $crud->name() !== config('ladmin.route.register')) {
                return $crud;
            }
        }

        return null;
    }

    public function route(?string $name = null): string|null
    {
        return $this->crud($name)->route();
    }

    public function login(): Crud|null
    {
        return $this->crud(config('ladmin.auth.login.name'));
    }

    public function logout(): Crud|null
    {
        return $this->crud(config('ladmin.auth.logout.name'));
    }

    public function profile(): Crud|null
    {
        return $this->crud(config('ladmin.profile.show.name'));
    }

    public function password(): Crud|null
    {
        return $this->crud(config('ladmin.profile.password-update.name'));
    }

    public function hasProfile(): Crud|null
    {
        return $this->crud(config('ladmin.profile.show.name'));
    }
}
