<?php

declare(strict_types=1);

namespace HSkrasek\ModelMigrator\Tests\Models;

use HSkrasek\ModelMigrator\Migratable;
use Illuminate\Database\Eloquent\Model;

class IncorrectModel extends Model
{
    use Migratable;
}
