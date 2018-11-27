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
    //return view('landing_page');
    return redirect('projects');
});


Route::resource('projects', 'ProjectsController');

Route::post('/projects/{project}/tasks', 'ProjectTasksController@store');
Route::patch('/tasks/{task}', 'ProjectTasksController@update');
/* 
    METHOD      URI                 FUNCTION        DESCRIPTION
    GET         /projects           (index)         [display a page with all projects]              1
    GET         /projects/create    (create)        [display a form to create a project]            2
    GET         /projects/1         (show)          [display a page with one particular project]    3
    POST        /projects           (store)         [store the project in the database]             4
    GET         /projects/1/edit    (edit)          [display a edit page to a particular project]   5
    PATCH       /projects/1         (update)        [update the project in the database]            6
    DELETE      /projects/1         (destroy)       [delete the project from the database]          7

    Route::get('/projects', 'ProjectsController@index');                    // 1
    Route::get('/projects/create', 'ProjectsController@create');            // 2    
    Route::get('/projects/{project}', 'ProjectsController@show');           // 3
    Route::post('/projects', 'ProjectsController@store');                   // 4
    Route::get('/projects/{project}/edit', 'ProjectsController@edit');      // 5
    Route::patch('/projects/{project}', 'ProjectsController@update');       // 6
    Route::delete('/projects/{project}', 'ProjectsController@destroy');     // 7

    All this routes are created using -> Route::resource('reference', 'ReferenceController');
*/
Auth::routes();

Route::get('/welcome', 'HomeController@index')->name('welcome');
