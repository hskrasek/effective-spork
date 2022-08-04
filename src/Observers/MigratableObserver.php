<?php

declare(strict_types=1);

namespace HSkrasek\ModelMigrator\Observers;

use HSkrasek\ModelMigrator\Contracts\Migratable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MigratableObserver
{
    /**
     * Only migrate a model after any open transactions are completed
     *
     * @var bool
     */
    public bool $afterCommit = true;

    public function created(Migratable|Model $model): void
    {
        DB::transaction(static fn () => $model->migrateAndSave());
    }

    public function updated(Migratable|Model $model): void
    {
        DB::transaction(static fn () => $model);
    }
}
