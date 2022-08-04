<?php

declare(strict_types=1);

namespace HSkrasek\ModelMigrator\Contracts;

use Illuminate\Database\Eloquent\Model;

/**
 * @template T of Model
 * @phpstan-template T of Model
 */
interface Migratable
{
    /**
     * @return T
     */
    public function migrate(): Model;

    public function migrateAndSave(): bool;

    //TODO: Determine how to handle updates with migratable models
    //What is the method name?
    public function migrateChanges(): Model;
}
