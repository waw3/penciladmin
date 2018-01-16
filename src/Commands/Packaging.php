<?php


namespace Waw3\PencilAdmin\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Waw3\PencilAdmin\Helpers\Helper;

/**
 * Class Packaging
 * @package Waw3\PencilAdmin\Commands
 *
 * Command to put latest development and changes of project into PencilAdmin package.
 * [For PencilAdmin Developer's Only]
 */
class Packaging extends Command
{
    // The command signature.
    var $modelsInstalled = ["User", "Role", "Permission", "Employee", "Department", "Upload", "Organization", "Backup"];

    // The command description.
    protected $signature = 'pa:packaging';

    // Copy From Folder - Package Install Files
    protected $description = '[Developer Only] - Copy PencilAdmin-Dev files to package: "waw3/penciladmin"';

    // Copy to Folder - Project Folder
    protected $from;

    // Model Names to be handled during Packaging
    protected $to;

    /**
     * Copy Project changes into PencilAdmin package.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Exporting started...');

        $from = base_path();
        $to = base_path('packages/waw3/penciladmin/src/Installs');

        $this->info('from: ' . $from . " to: " . $to);

        // Controllers
        $this->line('Exporting Controllers...');
        $this->replaceFolder($from . "/app/Http/Controllers/Auth", $to . "/app/Controllers/Auth");
        $this->replaceFolder($from . "/app/Http/Controllers/PencilAdmin", $to . "/app/Controllers/PencilAdmin");
        $this->copyFile($from . "/app/Http/Controllers/Controller.php", $to . "/app/Controllers/Controller.php");
        $this->copyFile($from . "/app/Http/Controllers/HomeController.php", $to . "/app/Controllers/HomeController.php");

        // Models
        $this->line('Exporting Models...');

        foreach($this->modelsInstalled as $model) {
            if($model == "User" || $model == "Role" || $model == "Permission") {
                $this->copyFile($from . "/app/" . $model . ".php", $to . "/app/Models/" . $model . ".php");
            } else {
                $this->copyFile($from . "/app/Models/" . $model . ".php", $to . "/app/Models/" . $model . ".php");
            }
        }

        // Routes
        $this->line('Exporting Routes...');
        $this->copyFile($from . "/routes/admin_routes.php", $to . "/app/admin_routes.php");

        // tests
        $this->line('Exporting tests...');
        $this->replaceFolder($from . "/tests", $to . "/tests");

        // Config
        $this->line('Exporting Config...');
        $this->copyFile($from . "/config/penciladmin.php", $to . "/config/penciladmin.php");

        // pa-assets
        $this->line('Exporting PencilAdmin Assets...');
        $this->replaceFolder($from . "/public/pa-assets", $to . "/pa-assets");
        // Use "git config core.fileMode false" for ignoring file permissions

        // migrations
        $this->line('Exporting migrations...');
        $this->replaceFolder($from . "/database/migrations", $to . "/migrations");

        // seeds
        $this->line('Exporting seeds...');
        $this->copyFile($from . "/database/seeds/DatabaseSeeder.php", $to . "/seeds/DatabaseSeeder.php");

        // resources
        $this->line('Exporting resources: assets + views...');
        $this->replaceFolder($from . "/resources/assets", $to . "/resources/assets");
        $this->replaceFolder($from . "/resources/views", $to . "/resources/views");

        // Utilities
        $this->line('Exporting Utilities...');
        // $this->copyFile($from."/gulpfile.js", $to."/gulpfile.js"); // Temporarily Not used.
    }

    /**
     * Replace Folder contents by deleting content of to folder first
     *
     * @param $from from folder
     * @param $to to folder
     */
    private function replaceFolder($from, $to)
    {
        $this->info("replaceFolder: ($from, $to)");
        if(file_exists($to)) {
            Helper::recurse_delete($to);
        }
        Helper::recurse_copy($from, $to);
    }

    /**
     * Copy file contents. If file not exists create it.
     *
     * @param $from from file
     * @param $to to file
     */
    private function copyFile($from, $to)
    {
        $this->info("copyFile: ($from, $to)");
        //Helper::recurse_copy($from, $to);
        if(!file_exists(dirname($to))) {
            $this->info("mkdir: (" . dirname($to) . ")");
            mkdir(dirname($to));
        }
        copy($from, $to);
    }
}
