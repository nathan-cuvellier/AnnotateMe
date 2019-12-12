<?php
session()->start();
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

Route::get('/test', 'essaiController@show')->name('test');


//Acces a la vue du compte ( profile )




Route::get('/register', 'Account\CreateController@show')->name('account.create');
Route::post('/register', 'Account\CreateController@register');

Route::group(['prefix' => 'account'], function () {

    //Route for the list of Experts
    Route::get('/list', 'Account\ListController@list')->name('account.list');

    Route::get('/{id}/read', 'Account\ReadController@view')->name('account.read');
    Route::get('/{id}/update', 'Account\UpdateController@view')->name('account.update');
    Route::post('/{id}/update', 'Account\UpdateController@update')->name('account.update.post');

    Route::post('/{id}/delete', 'Account\DeleteController@delete')->name('account.delete');
});

Route::group(['prefix' => 'project'], function () {
    //Route for the list of project (default page)
    Route::get('/', 'Project\ListController@show')->name('project.list');

    Route::get('/{id}/read', 'Project\ReadController@show')->name('project.read');


    Route::get('/{id}/update', 'Project\UpdateController@show')->name('project.update');
    Route::post('/{id}/update', 'Project\UpdateController@update')->name('project.update.post');

    Route::post('/{id}/delete', 'Project\DeleteController@delete')->name('project.delete');


    Route::get('/{id}/annotate','Project\AnnotationController@show')->name('project.annotate');
    Route::post('/{id}/annotate','Project\AnnotationController@annotate')->name('project.annotate.post');;

    //Route for the creation of a new project
    Route::get('/create', 'Project\CreateController@create')->name('project.create');
    Route::post('/create', 'Project\CreateController@check');


    Route::group(['prefix' => 'annotate'], function () {
        Route::get('/simple', 'Annotation\SimpleController@showSimple')->name('annotation.simple');
        Route::get('/double', 'Annotation\SimpleController@showDouble')->name('annotation.double');
        Route::get('/triple', 'Annotation\SimpleController@showTriple')->name('annotation.triple');
    });

    Route::group(['prefix' => '{id_prj}'], function(){

        //Routes for the Export and Dowload of Datas
        Route::group(['prefix' => 'export'], function(){

            //Routes for the Export and Dowload of Datas from a Project
            Route::match(['get', 'post'], '/', 'Project\ExportController@indexExport')->name('projects_project_export');

            Route::get('confirm', 'Project\ExportController@indexExportConfirm')->name('projects_project_export_confirmed');
            Route::post('download', 'Project\ExportController@downloadDatas')->name('projects_project_export_download');
        });

    });

    
});