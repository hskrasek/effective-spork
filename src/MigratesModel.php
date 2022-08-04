<?php

declare(strict_types=1);

namespace HSkrasek\ModelMigrator;

use Illuminate\Database\Eloquent\Model;

/**
 * @property-read class-string<Model> $targetModel
 * @property-read array<string, string> $migratableAttributes
 */
trait MigratesModel
{
    public function migrate(): Model
    {
        if (!isset($this->targetModel)) {
            throw new \InvalidArgumentException(
                'Unable to migrate ' . get_class($this) . '. Missing required target model.'
            );
        }

        if (empty($this->migratableAttributes)) {
            throw new \InvalidArgumentException(
                'Unable to migrate ' . get_class($this) . '. Migration attribute mapping missing.'
            );
        }

        $attributes = [];

        $original = $this->getOriginal();

        foreach ($this->migratableAttributes as $sourceAttribute => $targetAttribute) {
            $attributes[$targetAttribute] = $original[$sourceAttribute];
        }

        //TODO: Determine how to handle relationships while migrating

        return new $this->targetModel($attributes);
    }

    public function migrateAndSave(): bool
    {
        return $this->migrate()->save();
    }

    public function migrateChanges(): Model
    {
        if (!isset($this->targetModel)) {
            throw new \InvalidArgumentException(
                'Unable to migrate ' . get_class($this) . '. Missing required target model.'
            );
        }

        if (empty($this->migratableAttributes)) {
            throw new \InvalidArgumentException(
                'Unable to migrate ' . get_class($this) . '. Migration attribute mapping missing.'
            );
        }

        $attributes = [];

        $changes = $this->getChanges();

        foreach ($this->migratableAttributes as $sourceAttribute => $targetAttribute) {
            if (!array_key_exists($sourceAttribute, $changes)) {
                continue;
            }

            $attributes[$targetAttribute] = $changes[$sourceAttribute];
        }

        // Alright so, how the hell am I going to sync changes to the migrated model?
        // Requiring a key to be defined on each target model/table is too invasive IMO
        // Could I utilize a morph relationship to know the mapping after migration?

        return $this;
    }

    public function migratable()
    {
        return $this->morphToMany();
    }
}
