<?php

declare(strict_types=1);

namespace HSkrasek\ModelMigrator\Tests\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $fillable = [
        'street',
    ];
}
