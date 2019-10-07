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

//Sessions
session()->put("projetEnCours", 1);
session()->put("imageEnCours", 0);

//Route Home Login
Route::get('/', function () {
	return view('expertLogin');
})->name('auth');


//Routes for the Actions on the Account of the User
Route::group(['prefix' => 'account'], function(){

	Route::get('register', 'ExpertController@register')->name('account_register');
	Route::post('save', 'ExpertController@save')->name('account_save');
	Route::post('check', 'ExpertController@post')->name('account_check');
	Route::get('login', 'ExpertController@login')->name('account_login');

	//Group of Routes for Experts logout
	Route::group(['prefix' => 'logout'], function(){

		Route::match(['get','post'],'/', 'ExpertController@logout')->name('account_logout');
	});

	//Group of Routes for Experts Lists
	Route::group(['prefix' => 'list'], function(){

		//Route for the list of Experts
		Route::get('/', 'ExpertController@list')->name('account_experts_list');

		//Group of Routes for the Modification of Experts
		Route::group(['prefix' => '{id_exp}'],function(){

			//Route for Expert Update
			Route::get('update', 'ExpertController@update')->name('account_experts_expert_update');

			//Route for the Confirmation of Expert Update (usefull?)
			Route::post('update-confirmed', 'ExpertController@update_confirmed')->name('account_experts_expert_update_confirmed');

			//Route for the Deletion of Expert
			Route::post('delete-expert', 'ExpertController@delete_expert')->name('account_experts_expert_delete');
		});
	});

});

//Group of Routes for Projects Lists
Route::group(['prefix' => 'projects'], function(){

	//Projects List
	Route::match(['get','post'],'/', 'ProjectController@list')->name('projects_list');

	//Group of Routes for New Project
	Route::group(['prefix' => 'new'], function(){

		Route::match(['get','post'],'/', 'ProjectController@addProject')->name('projects_new');
	});

	//Group of Routes for the Save New Project or Update of existing ones
	Route::group(['prefix' => 'save'], function(){

		Route::match(['get','post'],'/', 'ProjectController@save')->name('projects_save');
	});


	//Group of Routes for a Particular Project
	Route::group(['prefix' => '{id_prj}'], function(){

		//Route for a Project
		Route::match(['get','post'],'/', 'ProjectController@details')->name('projects_project');

		//Route for Deleting a Project
		Route::group(['prefix' => 'delete'], function(){

			Route::get('/', 'ProjectController@delete')->name('projects_project_delete');
			Route::get('confirmed', 'ProjectController@delete_confirmed')->name('projects_project_delete_confirmed');
		});

		//Route for Updating a Project
		Route::group(['prefix' => 'update'], function(){

			Route::get('/', 'ProjectController@update')->name('projects_project_update');
			Route::post('confirmed', 'ProjectController@update_confirmed')->name('projects_project_update_confirmed');
		});

		//Group of Routes for the Annotation of a Project
		Route::group(['prefix' => 'annotation'], function(){

			//Route for the Annotation of a Project
			Route::match(['get','post'],'/', 'InterfaceController@view')->name('projects_project_annotation');
		});

		//Group of Routes for the Classification of a Project
		Route::group(['prefix' => 'classification'], function(){

			//Group of Routes for the Classification of a Project with Simple Annotation
			Route::group(['prefix' => 'simple'], function(){

				//Route for the Interface of Classification
				Route::get('/', 'InterfaceController@view')->name('projects_project_simple_classification');

				//Group of Routes for the Validation of a Classification
				Route::group(['prefix' => 'valide'], function(){

					//Route for the Validation of a Classification
					Route::match(['get','post'],'/', 'InterfaceController@store')->name('projects_project_simple_classification_validate');
				});

			});

			//Group of Routes for the Classification of a Project with Double Annotation
			Route::group(['prefix' => 'double'], function(){

				//Route for the Interface of Classification
				Route::get('/', 'InterfaceController@view')->name('projects_project_double_classification');

				//Group of Routes for the Validation of a Classification
				Route::group(['prefix' => 'valide'], function(){

					//Route for the Validation of a Classification
					Route::match(['get','post'],'/', 'InterfaceController@store')->name('projects_project_double_classification_validate');
				});
			});

			//Group of Routes for the Classification of a Project with Triple Annotation
			Route::group(['prefix' => 'triple'], function(){

				//Route for the Interface of Classification
				Route::get('/', 'InterfaceController@view')->name('projects_project_triple_classification');

				//Group of Routes for the Validation of a Classification
				Route::group(['prefix' => 'valide'], function(){


					//Route for the Validation of a Classification
					Route::match(['get','post'],'/', 'InterfaceController@store')->name('projects_project_triple_classification_validate');

				});
			});

		});

		//Routes for the Export and Dowload of Datas
		Route::group(['prefix' => 'export'], function(){

			//Routes for the Export and Dowload of Datas from a Project
			Route::match(['get','post'],'/', 'AnnotationController@indexExport')->name('projects_project_export');

			Route::get('confirm', 'AnnotationController@indexExportConfirm')->name('projects_project_export_confirmed');
			Route::post('download', 'AnnotationController@downloadDatas')->name('projects_project_export_download');
		});

	});

});

