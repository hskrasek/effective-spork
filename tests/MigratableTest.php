<?php

use HSkrasek\ModelMigrator\Migratable;
use HSkrasek\ModelMigrator\Tests\Models\Person;

use HSkrasek\ModelMigrator\Tests\Models\User;

use Illuminate\Database\Eloquent\Model;

use function Pest\Faker\faker;

it('throws an exception when a target model has not been defined', function () {
    $model = new class () extends Model {
        use Migratable;
    };
    $model->migrate();
})->throws(InvalidArgumentException::class, );

it('throws an exception when the migratable attributes properly is not defined', function () {
    $model = new class () extends Model {
        use Migratable;

        protected $targetModel = Model::class;
    };
    $model->migrate();
})->throws(InvalidArgumentException::class, );

it('migrates the model, properly mapping the configured attributes', function () {
    /** @var Person $person */
    $person = Person::unguarded(static fn () => new Person(
        [
            'address' => faker()->address,
        ]
    ));
    $person->save();

    expect($user = $person->migrate())->toBeInstanceOf(User::class)
        ->and($user->street)->toEqual($person->address)
        ->and($user->exists)->toBeFalse();
});

it('migrates the model and saves the new model immediately', function () {
    /** @var Person $person */
    $person = Person::unguarded(static fn () => new Person(
        [
            'address' => faker()->address,
        ]
    ));
    $person->save();

    expect($person->migrateAndSave())->toBeTrue()
        ->and($user = User::where('street', $person->address)->first())
        ->toBeInstanceOf(User::class)
        ->and($user->exists)
        ->toBeTrue();
});
