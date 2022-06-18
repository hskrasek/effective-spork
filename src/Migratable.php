<?php

declare(strict_types=1);

namespace HSkrasek\ModelMigrator;

use Illuminate\Database\Eloquent\Model;

/**
 * @template T of Model
 * @property-read class-string<T> $targetModel
 * @property-read array<string, string> $migratableAttributes
 */
trait Migratable
{
    /**
     * @return T
     */
    public function migrate(): Model
    {
        if (!isset($this->targetModel)) {
            throw new \InvalidArgumentException('Unable to migrate ' . get_class($this) . '. Missing required target model.');
        }

        if (empty($this->migratableAttributes)) {
            throw new \InvalidArgumentException('Unable to migrate ' . get_class($this) . '. Migration attribute mapping missing.');
        }

        $attributes = [];

        $original = $this->getOriginal();

        foreach ($this->migratableAttributes as $sourceAttribute => $targetAttribute) {
            $attributes[$targetAttribute] = $original[$sourceAttribute];
        }

        return new $this->targetModel($attributes);
    }

    public function migrateAndSave(): bool
    {
        return $this->migrate()->save();
    }
}
