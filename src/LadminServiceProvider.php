<?php

namespace LowB\Ladmin;

use Illuminate\Support\Facades\Blade;
use LowB\Ladmin\Commands\LadminCommand;
use LowB\Ladmin\Commands\MakeCrudControllerCommand;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

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
            ->hasCommand(MakeCrudControllerCommand::class)
            ->hasInstallCommand(function (InstallCommand $command) {
                $command
                    ->publishConfigFile()
                    ->publishMigrations()
                    ->askToRunMigrations();
            });
        Blade::component('ladmin-layouts-ladmin', \LowB\Ladmin\View\Components\LadminLayout::class);
        Blade::component('ladmin-layouts-auth', \LowB\Ladmin\View\Components\LadminAuthLayout::class);
        Blade::component('ladmin-layouts-guest', \LowB\Ladmin\View\Components\LadminGuestLayout::class);
    }
}
