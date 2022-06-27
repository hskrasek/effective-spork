<?php

declare(strict_types=1);

namespace HSkrasek\ModelMigrator\Tests\Models;

use HSkrasek\ModelMigrator\Contracts\Migratable;
use HSkrasek\ModelMigrator\MigratesModel;
use Illuminate\Database\Eloquent\Model;

class Person extends Model implements Migratable
{
    use MigratesModel;

    protected $table = 'persons';

    protected $targetModel = User::class;

    protected array $migratableAttributes = [
        'address' => 'street',
    ];
}
