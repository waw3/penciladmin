<?php


namespace Waw3\PencilAdmin\Commands;

use Illuminate\Console\Command;

use Waw3\PencilAdmin\CodeGenerator;

/**
 * Class Migration
 * @package Waw3\PencilAdmin\Commands
 *
 * Command to generation new sample migration file or complete migration file from DB Context
 * if '--generate' parameter is used after command, it generate migration from database.
 */
class Migration extends Command
{
    // The command signature.
    protected $signature = 'pa:migration {table} {--generate}';

    // The command description.
    protected $description = 'Generate Migrations for PencilAdmin';

    /**
     * Generate a Migration file either sample or from DB Context
     *
     * @return mixed
     */
    public function handle()
    {
        $table = $this->argument('table');
        $generateFromTable = $this->option('generate');
        if($generateFromTable) {
            $generateFromTable = true;
        }
        CodeGenerator::generateMigration($table, $generateFromTable, $this);
    }
}
