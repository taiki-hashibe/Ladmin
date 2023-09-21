<?php

namespace LowB\Ladmin;

use Illuminate\Support\Facades\Blade;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use LowB\Ladmin\Commands\LadminCommand;
use LowB\Ladmin\Commands\MakeControllerCommand;

class LadminServiceProvider extends PackageServiceProvider
{
    public function register()
    {
        parent::register();
        $this->app->bind('myName', \Reffect\MyName::class);
    }

    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('ladmin')
            ->hasAssets()
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_ladmin_table')
            ->hasCommand(LadminCommand::class)
            ->hasCommand(MakeControllerCommand::class)
            ->hasInstallCommand(function (InstallCommand $command) {
                $command
                    ->publishConfigFile()
                    ->publishMigrations()
                    ->askToRunMigrations();
            });;
        Blade::component('layouts-ladmin', \LowB\Ladmin\View\Components\LadminLayout::class);
        Blade::component('layouts-auth', \LowB\Ladmin\View\Components\AuthLayout::class);
        Blade::component('layouts-guest', \LowB\Ladmin\View\Components\GuestLayout::class);
    }
}
