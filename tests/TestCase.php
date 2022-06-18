<?php

namespace HSkrasek\ModelMigrator\Tests;

use HSkrasek\ModelMigrator\ModelMigratorServiceProvider;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'HSkrasek\\ModelMigrator\\Database\\Factories\\' . class_basename(
                $modelName
            ) . 'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            ModelMigratorServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');
    }

    protected function defineDatabaseMigrations()
    {
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
    }
}
