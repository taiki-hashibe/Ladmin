<?php

namespace LowB\Ladmin\Route;

use Exception;
use LowB\Ladmin\Controllers\CrudController;
use LowB\Ladmin\Controllers\DashboardController;
use LowB\Ladmin\Controllers\ProfileController;
use LowB\Ladmin\Support\Query\LadminQuery;
use Illuminate\Support\Facades\Route as SupportRoute;
use LowB\Ladmin\Controllers\AuthController;

class LadminRoute extends BaseLadminRoute
{
    public function getRoutes()
    {
        return $this->routes;
    }

    public function getCurrentRoute(): mixed
    {
        $currentRouteName = SupportRoute::currentRouteName();
        if ($currentRouteName === null) {
            throw new Exception("Current route name is not available.");
        }
        foreach ($this->routes as $route) {
            $routeName = $route->getRoute()->action['as'];
            if ($currentRouteName === $routeName) {
                return $route;
            }
        }
        return null;
    }

    public function show(string $modelOrTable, string $controllerName = CrudController::class): mixed
    {
        return $this->_show(LadminQuery::make($modelOrTable), $this->makeController($controllerName));
    }

    public function detail(string $modelOrTable, string $controllerName = CrudController::class): mixed
    {
        return $this->_detail(LadminQuery::make($modelOrTable), $this->makeController($controllerName));
    }

    public function edit(string $modelOrTable, string $controllerName = CrudController::class): mixed
    {
        return $this->_edit(LadminQuery::make($modelOrTable), $this->makeController($controllerName));
    }

    public function create(string $modelOrTable, string $controllerName = CrudController::class): mixed
    {
        return $this->_create(LadminQuery::make($modelOrTable), $this->makeController($controllerName));
    }

    public function update(string $modelOrTable, string $controllerName = CrudController::class): mixed
    {
        return $this->_update(LadminQuery::make($modelOrTable), $this->makeController($controllerName));
    }

    public function destroy(string $modelOrTable, string $controllerName = CrudController::class): mixed
    {
        return $this->_destroy(LadminQuery::make($modelOrTable), $this->makeController($controllerName));
    }

    public function auth(string $controllerName = AuthController::class): mixed
    {
        $this->get('/login', [$controllerName, 'login'])->setGroupName('auth')->setLabel('Login');
        $this->post('/login/register', [$controllerName, 'register'])->setGroupName('auth');
        $this->useMiddleware = true;
        return $this->get('/logout', [$controllerName, 'logout'])->setGroupName('auth')->setLabel('Logout')->setNavigation(['dropdown']);
    }

    public function dashboard(string $controllerName = DashboardController::class): mixed
    {
        return $this->get('/dashboard', [$controllerName, 'index'])
            ->setGroupName('dashboard')
            ->setLabel('Dashboard')
            ->setNavigation(['navigation']);
    }

    public function profile(string $controllerName = ProfileController::class): mixed
    {
        $this->post('/profile/update', [$controllerName, 'update'])->setGroupName('profile');
        $this->post('/profile/destroy', [$controllerName, 'destroy'])->setGroupName('profile');
        $this->post('/profile/password-change', [$controllerName, 'passwordChange'])->setGroupName('profile');
        return $this->get('/profile', [$controllerName, 'index'])
            ->setGroupName('profile')
            ->setLabel('Profile')
            ->setNavigation(['dropdown']);
    }

    public function crud(string $modelOrTable, string $controllerName = CrudController::class): mixed
    {
        $query = LadminQuery::make($modelOrTable);
        $controller = $this->makeController($controllerName);
        $this->_detail($query, $controller);
        $this->_edit($query, $controller);
        $this->_create($query, $controller);
        $this->_update($query, $controller);
        $this->_destroy($query, $controller);

        return $this->_show($query, $controller);
    }
}
