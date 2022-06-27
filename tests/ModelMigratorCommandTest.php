<?php

use HSkrasek\ModelMigrator\Tests\Models\Person;

use Illuminate\Console\Command;

use function Pest\Laravel\artisan;

it('migrates a model to the target model', function () {
    artisan('migrator:migrate', ['class' => Person::class,])
        ->assertSuccessful()
        ->expectsOutputToContain(basename(Person::class))
        ->assertExitCode(Command::SUCCESS);
});

it('fails to migrate a model class that does not exist', function () {
    artisan('migrator:migrate', ['class' => 'App\Class\Does\NotExist',])
        ->assertFailed()
        ->assertExitCode(Command::INVALID)
        ->expectsOutput('App\Class\Does\NotExist does not exist or is not properly auto-loaded');
});

it('fails to migrate a model with a less than one chunk size', function () {
    artisan('migrator:migrate', ['class' => Person::class, '--chunk-size' => 0])
        ->assertFailed()
        ->assertExitCode(Command::INVALID)
        ->expectsOutput('Chunk size needs to be >= 1, 0 provided.');
});

it('does not migrate the model if the environment is production and no force was provided', function () {
    config()->set('app.environment', 'production');

    artisan('migrator:migrate', ['class' => Person::class, '--env' => 'production'])
        ->expectsConfirmation('Do you really want to run this command?', 'no')
        ->assertFailed();
})->skip('Testing environment is not being properly overloaded');
