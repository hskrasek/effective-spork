<?php

namespace HSkrasek\ModelMigrator\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \HSkrasek\ModelMigrator\ModelMigrator
 */
class ModelMigrator extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'model-migrator';
    }
}
