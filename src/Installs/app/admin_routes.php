<?php

/* ================== Homepage ================== */
Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index');
Route::auth();

/* ================== Access Uploaded Files ================== */
Route::get('files/{hash}/{name}', 'PA\UploadsController@get_file');

/*
|--------------------------------------------------------------------------
| Admin Application Routes
|--------------------------------------------------------------------------
*/

$as = "";
if(\Waw3\PencilAdmin\Helpers\PAHelper::laravel_ver() == 5.3) {
	$as = config('penciladmin.adminRoute').'.';

	// Routes for Laravel 5.3
	Route::get('/logout', 'Auth\LoginController@logout');
}

Route::group(['as' => $as, 'middleware' => ['auth', 'permission:ADMIN_PANEL']], function () {

	/* ================== Dashboard ================== */

	Route::get(config('penciladmin.adminRoute'), 'PA\DashboardController@index');
	Route::get(config('penciladmin.adminRoute'). '/dashboard', 'PA\DashboardController@index');

	/* ================== Users ================== */
	Route::resource(config('penciladmin.adminRoute') . '/users', 'PA\UsersController');
	Route::get(config('penciladmin.adminRoute') . '/user_dt_ajax', 'PA\UsersController@dtajax');

	/* ================== Uploads ================== */
	Route::resource(config('penciladmin.adminRoute') . '/uploads', 'PA\UploadsController');
	Route::post(config('penciladmin.adminRoute') . '/upload_files', 'PA\UploadsController@upload_files');
	Route::get(config('penciladmin.adminRoute') . '/uploaded_files', 'PA\UploadsController@uploaded_files');
	Route::post(config('penciladmin.adminRoute') . '/uploads_update_caption', 'PA\UploadsController@update_caption');
	Route::post(config('penciladmin.adminRoute') . '/uploads_update_filename', 'PA\UploadsController@update_filename');
	Route::post(config('penciladmin.adminRoute') . '/uploads_update_public', 'PA\UploadsController@update_public');
	Route::post(config('penciladmin.adminRoute') . '/uploads_delete_file', 'PA\UploadsController@delete_file');

	/* ================== Roles ================== */
	Route::resource(config('penciladmin.adminRoute') . '/roles', 'PA\RolesController');
	Route::get(config('penciladmin.adminRoute') . '/role_dt_ajax', 'PA\RolesController@dtajax');
	Route::post(config('penciladmin.adminRoute') . '/save_module_role_permissions/{id}', 'PA\RolesController@save_module_role_permissions');

	/* ================== Permissions ================== */
	Route::resource(config('penciladmin.adminRoute') . '/permissions', 'PA\PermissionsController');
	Route::get(config('penciladmin.adminRoute') . '/permission_dt_ajax', 'PA\PermissionsController@dtajax');
	Route::post(config('penciladmin.adminRoute') . '/save_permissions/{id}', 'PA\PermissionsController@save_permissions');

	/* ================== Departments ================== */
	Route::resource(config('penciladmin.adminRoute') . '/departments', 'PA\DepartmentsController');
	Route::get(config('penciladmin.adminRoute') . '/department_dt_ajax', 'PA\DepartmentsController@dtajax');

	/* ================== Employees ================== */
	Route::resource(config('penciladmin.adminRoute') . '/employees', 'PA\EmployeesController');
	Route::get(config('penciladmin.adminRoute') . '/employee_dt_ajax', 'PA\EmployeesController@dtajax');
	Route::post(config('penciladmin.adminRoute') . '/change_password/{id}', 'PA\EmployeesController@change_password');

	/* ================== Organizations ================== */
	Route::resource(config('penciladmin.adminRoute') . '/organizations', 'PA\OrganizationsController');
	Route::get(config('penciladmin.adminRoute') . '/organization_dt_ajax', 'PA\OrganizationsController@dtajax');

	/* ================== Backups ================== */
	Route::resource(config('penciladmin.adminRoute') . '/backups', 'PA\BackupsController');
	Route::get(config('penciladmin.adminRoute') . '/backup_dt_ajax', 'PA\BackupsController@dtajax');
	Route::post(config('penciladmin.adminRoute') . '/create_backup_ajax', 'PA\BackupsController@create_backup_ajax');
	Route::get(config('penciladmin.adminRoute') . '/downloadBackup/{id}', 'PA\BackupsController@downloadBackup');
});
