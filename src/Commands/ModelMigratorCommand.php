<?php

namespace HSkrasek\ModelMigrator\Commands;

use Illuminate\Console\Command;
use Illuminate\Console\ConfirmableTrait;
use Illuminate\Database\Eloquent\Model;

class ModelMigratorCommand extends Command
{
    use ConfirmableTrait;

    public $signature = 'migrator:migrate
                            {class : The fully qualified class name of the model to migrate}
                            {-S|--chunk-size=100 : The number of models to migrate at a time}
                            {--force : Force the operation to run when in production}';

    public $description = 'Bulk migrate a model to their target model';

    public function handle(): int
    {
        dd($this->getLaravel()->environment());

        if (!$this->confirmToProceed()) {
            return self::FAILURE;
        }

        /** @var class-string $class */
        $class = $this->argument('class');
        $modelName = basename($class);

        if (!class_exists($class)) {
            $this->error("$class does not exist or is not properly auto-loaded");

            return self::INVALID;
        }

        $chunkSize = (int)$this->option('chunk-size');

        if ($chunkSize < 1) {
            $this->error("Chunk size needs to be >= 1, $chunkSize provided.");

            return self::INVALID;
        }

        $class::chunk($chunkSize, function (array $models, int $page) use ($modelName, $chunkSize): bool {
            /** @var array<int, Model> $models */
            foreach ($models as $model) {
                // TODO: Implement something that allows better type hinting/inference
                /** @phpstan-ignore-next-line */
                if (!$model->migrateAndSave()) {
                    return false;
                }
            }

            $migratedModels = $chunkSize * $page;

            $this->info("Migrated {$migratedModels} $modelName models");

            return true;
        });

        $this->comment("Finished migrating all $modelName models");

        return self::SUCCESS;
    }
}
