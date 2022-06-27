<?php

namespace HSkrasek\ModelMigrator;

use HSkrasek\ModelMigrator\Commands\ModelMigratorCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class ModelMigratorServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('model-migrator')
            ->hasCommand(ModelMigratorCommand::class)
            ->hasConfigFile();
    }
}
