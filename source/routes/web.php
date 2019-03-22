<?php

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

Route::get('/', function () {
	return view('expertLogin');
});

Route::get('/home', 'HomeController@index')->name('home');

Route::post('check', 'ExpertController@post')->name('check');
Route::get('login', 'ExpertController@login');
Route::get('register', 'ExpertController@register');
Route::post('save', 'ExpertController@save')->name('save');
//ExpertUpdate
Route::get('list', 'ExpertController@list');
Route::get('list/{id_exp}/update', 'ExpertController@update');
Route::post('list/{id_exp}/update-confirmed', 'ExpertController@update_confirmed');
//expert_delete
Route::post('list/{id_exp}/delete-expert', 'ExpertController@delete_expert');


Route::get('logout', 'ExpertController@logout');
Route::post('logout', 'ExpertController@logout')	;


//
Route::get('/projects/{id_prj}/annotation', 'InterfaceController@view');
Route::post('/projects/{id_prj}/annotation', 'InterfaceController@view');

//Classification
Route::get('/projects/{id_prj}/classification', 'InterfaceController@view')->name('classification');

Route::post('/projects/{id_prj}/classification/valide', 'InterfaceController@store');
Route::get('/projects/{id_prj}/classification/valide', 'InterfaceController@store');

//Interface2
Route::get('/projects/{id_prj}/pairwise', 'InterfaceController@view')->name('pairwise');

Route::post('/projects/{id_prj}/pairwise/valide', 'InterfaceController@store');
Route::get('/projects/{id_prj}/pairwise/valide', 'InterfaceController@store');

//Interface3
Route::post('/projects/{id_prj}/tripletwise/valide', 'InterfaceController@store');
Route::get('/projects/{id_prj}/tripletwise/valide', 'InterfaceController@store');

session()->put("projetEnCours", 1);
session()->put("imageEnCours", 0);

// Export 
Route::get('/projects/{id_prj}/export', 'AnnotationController@indexExport');
Route::post('/projects/{id_prj}/exportDatas', 'AnnotationController@exportDatas');
Route::get('/projects/{id_prj}/exportConfirm', 'AnnotationController@indexExportConfirm');
Route::post('/projects/{id_prj}/download', 'AnnotationController@downloadDatas');

//liste projects
Route::get('/projects', 'ProjectController@list')->name('projects');
Route::post('/projects', 'ProjectController@list');


//details projects
Route::get('/projects/{id_prj}', 'ProjectController@details');
Route::post('/projects/{id_prj}', 'ProjectController@details');

//delete project
Route::get('/projects/{id_prj}/delete', 'ProjectController@delete');
Route::get('/projects/{id_prj}/delete-confirmed', 'ProjectController@delete_confirmed');

//update project
Route::get('/projects/{id_prj}/update', 'ProjectController@update');
Route::post('/projects/{id_prj}/update-confirmed', 'ProjectController@update_confirmed');

//CréationProjet
Route::get('newproject', 'ProjectController@addProject');
Route::post('newprojectExp', 'ProjectController@addProjectExp');
Route::post('projectSave', 'ProjectController@save');
Route::get('projectSave', 'ProjectController@save');