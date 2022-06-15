<?php

namespace HSkrasek\ModelMigrator;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use HSkrasek\ModelMigrator\Commands\ModelMigratorCommand;

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
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_model-migrator_table')
            ->hasCommand(ModelMigratorCommand::class);
    }
}
