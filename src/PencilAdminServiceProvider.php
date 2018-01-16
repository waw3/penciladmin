<?php namespace Waw3\PencilAdmin;

use Artisan;
use Illuminate\Support\Facades\Blade;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

use Waw3\PencilAdmin\Helpers\PAHelper;

/**
 * Class PencilAdminServiceProvider
 * @package Waw3\PencilAdmin
 *
 * This is PencilAdmin Service Provider which looks after managing aliases, other required providers, blade directives
 * and Commands.
 */
class PencilAdminServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // @mkdir(base_path('resources/penciladmin'));
        // @mkdir(base_path('database/migrations/penciladmin'));
        /*
        $this->publishes([
            __DIR__.'/Templates' => base_path('resources/penciladmin'),
            __DIR__.'/config.php' => base_path('config/penciladmin.php'),
            __DIR__.'/Migrations' => base_path('database/migrations/penciladmin')
        ]);
        */
        //echo "PencilAdmin Migrations started...";
        // Artisan::call('migrate', ['--path' => "vendor/waw3/penciladmin/src/Migrations/"]);
        //echo "Migrations completed !!!.";
        // Execute by php artisan vendor:publish --provider="Waw3\PencilAdmin\PencilAdminServiceProvider"

        /*
        |--------------------------------------------------------------------------
        | Blade Directives for Entrust not working in Laravel 5.3
        |--------------------------------------------------------------------------
        */
        if(PAHelper::laravel_ver() == 5.3) {

            // Call to Entrust::hasRole
            Blade::directive('role', function ($expression) {
                return "<?php if (\\Entrust::hasRole({$expression})) : ?>";
            });

            // Call to Entrust::can
            Blade::directive('permission', function ($expression) {
                return "<?php if (\\Entrust::can({$expression})) : ?>";
            });

            // Call to Entrust::ability
            Blade::directive('ability', function ($expression) {
                return "<?php if (\\Entrust::ability({$expression})) : ?>";
            });
        }
    }

    /**
     * Register the application services including routes, Required Providers, Alias, Controllers, Blade Directives
     * and Commands.
     *
     * @return void
     */
    public function register()
    {
        include __DIR__ . '/routes.php';

        // For PAEditor
        if(file_exists(__DIR__ . '/../../paeditor')) {
            include __DIR__ . '/../../paeditor/src/routes.php';
        }

        /*
        |--------------------------------------------------------------------------
        | Providers
        |--------------------------------------------------------------------------
        */

        // Collective HTML & Form Helper
        $this->app->register(\Collective\Html\HtmlServiceProvider::class);
        // For Datatables
        $this->app->register(\Yajra\Datatables\DatatablesServiceProvider::class);
        // For Gravatar
        $this->app->register(\Creativeorange\Gravatar\GravatarServiceProvider::class);
        // For Entrust
        $this->app->register(\Zizaco\Entrust\EntrustServiceProvider::class);
        // For Spatie Backup
        $this->app->register(\Spatie\Backup\BackupServiceProvider::class);

        /*
        |--------------------------------------------------------------------------
        | Register the Alias
        |--------------------------------------------------------------------------
        */

        $loader = AliasLoader::getInstance();

        // Collective HTML & Form Helper
        $loader->alias('Form', \Collective\Html\FormFacade::class);
        $loader->alias('HTML', \Collective\Html\HtmlFacade::class);

        // For Gravatar User Profile Pics
        $loader->alias('Gravatar', \Creativeorange\Gravatar\Facades\Gravatar::class);

        // For PencilAdmin Code Generation
        $loader->alias('CodeGenerator', \Waw3\PencilAdmin\CodeGenerator::class);

        // For PencilAdmin Form Helper
        $loader->alias('PAFormMaker', \Waw3\PencilAdmin\PAFormMaker::class);

        // For PencilAdmin Helper
        $loader->alias('PAHelper', \Waw3\PencilAdmin\Helpers\PAHelper::class);

        // PencilAdmin Module Model
        $loader->alias('Module', \Waw3\PencilAdmin\Models\Module::class);

        // For PencilAdmin Configuration Model
        $loader->alias('PAConfigs', \Waw3\PencilAdmin\Models\PAConfigs::class);

        // For Entrust
        $loader->alias('Entrust', \Zizaco\Entrust\EntrustFacade::class);
        $loader->alias('role', \Zizaco\Entrust\Middleware\EntrustRole::class);
        $loader->alias('permission', \Zizaco\Entrust\Middleware\EntrustPermission::class);
        $loader->alias('ability', \Zizaco\Entrust\Middleware\EntrustAbility::class);

        /*
        |--------------------------------------------------------------------------
        | Register the Controllers
        |--------------------------------------------------------------------------
        */

        $this->app->make('Waw3\PencilAdmin\Controllers\ModuleController');
        $this->app->make('Waw3\PencilAdmin\Controllers\FieldController');
        $this->app->make('Waw3\PencilAdmin\Controllers\MenuController');

        // For PAEditor
        if(file_exists(__DIR__ . '/../../paeditor')) {
            $this->app->make('Waw3\PAeditor\Controllers\CodeEditorController');
        }

        /*
        |--------------------------------------------------------------------------
        | Blade Directives
        |--------------------------------------------------------------------------
        */

        // PAForm Input Maker
        Blade::directive('pa_input', function ($expression) {
            if(PAHelper::laravel_ver() == 5.3) {
                $expression = "(" . $expression . ")";
            }
            return "<?php echo PAFormMaker::input$expression; ?>";
        });

        // PAForm Form Maker
        Blade::directive('pa_form', function ($expression) {
            if(PAHelper::laravel_ver() == 5.3) {
                $expression = "(" . $expression . ")";
            }
            return "<?php echo PAFormMaker::form$expression; ?>";
        });

        // PAForm Maker - Display Values
        Blade::directive('pa_display', function ($expression) {
            if(PAHelper::laravel_ver() == 5.3) {
                $expression = "(" . $expression . ")";
            }
            return "<?php echo PAFormMaker::display$expression; ?>";
        });

        // PAForm Maker - Check Whether User has Module Access
        Blade::directive('pa_access', function ($expression) {
            if(PAHelper::laravel_ver() == 5.3) {
                $expression = "(" . $expression . ")";
            }
            return "<?php if(PAFormMaker::pa_access$expression) { ?>";
        });
        Blade::directive('endpa_access', function ($expression) {
            return "<?php } ?>";
        });

        // PAForm Maker - Check Whether User has Module Field Access
        Blade::directive('pa_field_access', function ($expression) {
            if(PAHelper::laravel_ver() == 5.3) {
                $expression = "(" . $expression . ")";
            }
            return "<?php if(PAFormMaker::pa_field_access$expression) { ?>";
        });
        Blade::directive('endpa_field_access', function ($expression) {
            return "<?php } ?>";
        });

        /*
        |--------------------------------------------------------------------------
        | Register the Commands
        |--------------------------------------------------------------------------
        */

        $commands = [
            \Waw3\PencilAdmin\Commands\Migration::class,
            \Waw3\PencilAdmin\Commands\Crud::class,
            \Waw3\PencilAdmin\Commands\Packaging::class,
            \Waw3\PencilAdmin\Commands\PAInstall::class
        ];

        // For PAEditor
        if(file_exists(__DIR__ . '/../../paeditor')) {
            $commands[] = \Waw3\Paeditor\Commands\PAEditor::class;
        }

        $this->commands($commands);
    }
}
