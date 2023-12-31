<?php

namespace LowB\Ladmin\Route;

use Exception;
use Illuminate\Support\Str;
use LowB\Ladmin\Config\Facades\LadminConfig;
use LowB\Ladmin\Controllers\CrudController;
use LowB\Ladmin\Support\Query\LadminQuery;

class BaseLadminRoute
{
    public const PRIMARY_KEY = '{primaryKey}';

    public const PRIMARY_KEY_OPTIONAL = '{primaryKey?}';

    protected array $routes = [];

    protected bool $useMiddleware = false;

    public function __call($method, $args): Route
    {
        if (LadminConfig::config('view.prefix')) {
            $args[0] = '/'.LadminConfig::config('view.prefix').$args[0];
        }
        $router = Route::make()->{$method}(...$args)->name($this->generateName($args[0]));
        if ($this->useMiddleware) {
            $router->middleware(LadminConfig::config('middleware'));
        }
        $this->routes[] = $router;

        return $router;
    }

    protected function _crudRouting(LadminQuery $query, CrudController $controller, string $method, string $crudAction, string $actionName, string $primaryKey = null): Route
    {
        $uri = "/{$query->getTable()}/$crudAction".($primaryKey ? "/$primaryKey" : '');

        return $this->{$method}($uri, [$controller::class, $actionName])
            ->setTableName($query->getTable())
            ->setGroupName($query->getTable())
            ->setLabel($query->getTable())
            ->setCrudAction($crudAction);
    }

    protected function _show(LadminQuery $query, CrudController $controller): Route
    {
        return $this->_crudRouting($query, $controller, 'get', LadminConfig::config('uri.show'), 'show')->setNavigation(['navigation']);
    }

    protected function _detail(LadminQuery $query, CrudController $controller): Route
    {
        return $this->_crudRouting($query, $controller, 'get', LadminConfig::config('uri.detail'), 'detail', self::PRIMARY_KEY);
    }

    protected function _edit(LadminQuery $query, CrudController $controller): Route
    {
        return $this->_crudRouting($query, $controller, 'get', LadminConfig::config('uri.edit'), 'edit', self::PRIMARY_KEY_OPTIONAL);
    }

    protected function _create(LadminQuery $query, CrudController $controller): Route
    {
        return $this->_crudRouting($query, $controller, 'post', LadminConfig::config('uri.create'), 'create');
    }

    protected function _update(LadminQuery $query, CrudController $controller): Route
    {
        return $this->_crudRouting($query, $controller, 'post', LadminConfig::config('uri.update'), 'update', self::PRIMARY_KEY);
    }

    protected function _destroy(LadminQuery $query, CrudController $controller): Route
    {
        return $this->_crudRouting($query, $controller, 'post', LadminConfig::config('uri.destroy'), 'destroy', self::PRIMARY_KEY);
    }

    protected function makeCrudController(string $name = null, LadminQuery $query): CrudController
    {
        if (! $name) {
            if ($query->queryType === LadminQuery::TYPE_MODEL) {
                $name = LadminConfig::config('namespace.controller').'\\'.class_basename($query->query).'CrudController';
            } elseif ($query->queryType === LadminQuery::TYPE_BUILDER) {
                $name = LadminConfig::config('namespace.controller').'\\'.Str::studly($query->getTable()).'CrudController';
            }
            if (! class_exists($name) && ! is_subclass_of($name, CrudController::class)) {
                $name = CrudController::class;
            }
        }
        if (! class_exists($name)) {
            throw new Exception("Target class [$name] does not exist.");
        }

        return app()->make($name);
    }

    protected function generateName(string $uri)
    {
        $name = Str::of($uri)->replace('/', '.')->replaceFirst('.', '');

        return $name->__toString();
    }
}
