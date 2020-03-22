<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session()->start();
//\Debugbar::disable();
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'HomeController@index')->name('home');

Route::get('/login', 'Auth\LoginController@show')->name('auth.login');
Route::post('/login', 'Auth\LoginController@check');
Route::post('/logout', 'Auth\LogoutController@logout')->name('auth.logout');

Route::group(['prefix' => 'account'], function () {

    //Route for the list of Experts
    Route::get('/list', 'Account\ListController@list')->name('account.list');

    Route::get('/reset', 'Account\ResetController@view')->name('account.reset');
    Route::post('/reset', 'Account\ResetController@post');

    Route::get('/reset/token', 'Account\ResetController@resetView')->name('account.reset.token');
    Route::post('/reset/token', 'Account\ResetController@resetPost');

    Route::get('/create', 'Account\CRUD\CreateController@show')->name('account.create');
    Route::post('/create', 'Account\CRUD\CreateController@register');

    Route::get('/{id}/read', 'Account\CRUD\ReadController@view')->name('account.read');
    Route::get('/{id}/update', 'Account\CRUD\UpdateController@view')->name('account.update');
    Route::post('/{id}/update', 'Account\CRUD\UpdateController@update');

    Route::post('/{id}/delete', 'Account\CRUD\DeleteController@delete')->name('account.delete');
});

Route::group(['prefix' => 'project'], function () {
    //Route for the list of project (default page)
    Route::get('/', 'Project\ListController@show')->name('project.list');

    Route::get('/{id}/read', 'Project\CRUD\ReadController@show')->name('project.read');

    Route::get('/{id}/update', 'Project\CRUD\UpdateController@show')->name('project.update');
    Route::post('/{id}/update', 'Project\CRUD\UpdateController@update')->name('project.update.post');

    Route::post('/{id}/delete', 'Project\CRUD\DeleteController@delete')->name('project.delete');

    Route::get('/{id}/annotate', 'Project\AnnotationController@show')->name('project.annotate');
    Route::post('/{id}/annotate', 'Project\AnnotationController@annotate')->name('project.annotate.post');

    //Route for the creation of a new project
    Route::get('/create', 'Project\CRUD\CreateController@create')->name('project.create');
    Route::post('/create', 'Project\CRUD\CreateController@check');

    Route::group(['prefix' => 'annotate'], function () {
        Route::get('/simple', 'Annotation\SimpleController@showSimple')->name('annotation.simple');
        Route::get('/double', 'Annotation\SimpleController@showDouble')->name('annotation.double');
        Route::get('/triple', 'Annotation\SimpleController@showTriple')->name('annotation.triple');
    });

    Route::group(['prefix' => '{id}'], function () {

        //Routes for the Export and Dowload of Datas
        Route::group(['prefix' => 'export'], function () {

            //Routes for the Export and Dowload of Datas from a Project
            Route::match(['get', 'post'], '/', 'Project\ExportController@indexExport')->name('project.export');

        });
    });

});