<?php

namespace HSkrasek\ModelMigrator\Commands;

use Illuminate\Console\Command;

class ModelMigratorCommand extends Command
{
    public $signature = 'model-migrator';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
