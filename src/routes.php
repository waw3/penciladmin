<?php

$as = "";
if(\Waw3\PencilAdmin\Helpers\PAHelper::laravel_ver() == 5.3) {
    $as = config('penciladmin.adminRoute') . '.';
}

/**
 * Connect routes with ADMIN_PANEL permission(for security) and 'Waw3\PencilAdmin\Controllers' namespace
 * and '/admin' url.
 */
Route::group([
    'namespace' => 'Waw3\PencilAdmin\Controllers',
    'as' => $as,
    'middleware' => ['web', 'auth', 'permission:ADMIN_PANEL', 'role:SUPER_ADMIN']
], function () {

    /* ================== Modules ================== */
    Route::resource(config('penciladmin.adminRoute') . '/modules', 'ModuleController');
    Route::resource(config('penciladmin.adminRoute') . '/module_fields', 'FieldController');
    Route::get(config('penciladmin.adminRoute') . '/module_generate_crud/{model_id}', 'ModuleController@generate_crud');
    Route::get(config('penciladmin.adminRoute') . '/module_generate_migr/{model_id}', 'ModuleController@generate_migr');
    Route::get(config('penciladmin.adminRoute') . '/module_generate_update/{model_id}', 'ModuleController@generate_update');
    Route::get(config('penciladmin.adminRoute') . '/module_generate_migr_crud/{model_id}', 'ModuleController@generate_migr_crud');
    Route::get(config('penciladmin.adminRoute') . '/modules/{model_id}/set_view_col/{column_name}', 'ModuleController@set_view_col');
    Route::post(config('penciladmin.adminRoute') . '/save_role_module_permissions/{id}', 'ModuleController@save_role_module_permissions');
    Route::get(config('penciladmin.adminRoute') . '/save_module_field_sort/{model_id}', 'ModuleController@save_module_field_sort');
    Route::post(config('penciladmin.adminRoute') . '/check_unique_val/{field_id}', 'FieldController@check_unique_val');
    Route::get(config('penciladmin.adminRoute') . '/module_fields/{id}/delete', 'FieldController@destroy');
    Route::post(config('penciladmin.adminRoute') . '/get_module_files/{module_id}', 'ModuleController@get_module_files');
    Route::post(config('penciladmin.adminRoute') . '/module_update', 'ModuleController@update');
    Route::post(config('penciladmin.adminRoute') . '/module_field_listing_show', 'FieldController@module_field_listing_show_ajax');

    /* ================== Code Editor ================== */
    Route::get(config('penciladmin.adminRoute') . '/lacodeeditor', function () {
        if(file_exists(resource_path("views/la/editor/index.blade.php"))) {
            return redirect(config('penciladmin.adminRoute') . '/paeditor');
        } else {
            // show install code editor page
            return View('pa.editor.install');
        }
    });

    /* ================== Menu Editor ================== */
    Route::resource(config('penciladmin.adminRoute') . '/pa_menus', 'MenuController');
    Route::post(config('penciladmin.adminRoute') . '/pa_menus/update_hierarchy', 'MenuController@update_hierarchy');

    /* ================== Configuration ================== */
    Route::resource(config('penciladmin.adminRoute') . '/pa_configs', '\App\Http\Controllers\PA\PAConfigController');

    Route::group([
        'middleware' => 'role'
    ], function () {
        /*
        Route::get(config('penciladmin.adminRoute') . '/menu', [
            'as'   => 'menu',
            'uses' => 'PAController@index'
        ]);
        */
    });
});
