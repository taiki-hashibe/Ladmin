<?php

namespace LowB\Ladmin\Support;

use Exception;
use LowB\Ladmin\Route\Facades\LadminRoute as RouteLadminRoute;
use Illuminate\Support\Str;
use LowB\Ladmin\Route\Route;

class LadminRoute
{
    private array|null $routes = null;
    private Route|null $route = null;

    public function __call($method, $args)
    {
        if ($this->routes) {
            foreach ($this->routes as $route) {
                $routeMethod =  Str::of($route->getRoute()->action['uses'])->after('@')->__toString();
                $routeMethod = Str::camel($routeMethod);
                if ($method === $routeMethod) {
                    $this->route = $route;
                    return $this;
                }
            }
            throw new Exception("Route with method '$method' not found.");
        }
        $this->routes = [];
        $routes = RouteLadminRoute::getRoutes();
        foreach ($routes as $route) {
            if ($route->getGroupName() === $method) {
                $this->routes[] = $route;
            };
        }
        return $this;
    }

    public function __get($name)
    {
        if ($this->route) {
            if ($name === 'uri') {
                return $this->route->getRoute()->uri;
            }
            if ($name === 'url') {
                return "/" . $this->route->getRoute()->uri;
            }
            if ($name === 'name') {
                return $this->route->getRoute()->action['as'];
            }
        }
    }
}
