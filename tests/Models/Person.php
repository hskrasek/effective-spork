<?php

declare(strict_types=1);

namespace HSkrasek\ModelMigrator\Tests\Models;

use HSkrasek\ModelMigrator\Migratable;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    use Migratable;

    protected $table = 'persons';

    protected $targetModel = User::class;

    protected array $migratableAttributes = [
        'address' => 'street',
    ];
}
