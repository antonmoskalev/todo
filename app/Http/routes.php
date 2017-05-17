<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/
$app->get('/', ['as' => 'home', 'uses' => 'DefaultController@index']);

$app->group([
	'middleware' => 'guest',
	'namespace' => 'App\Http\Controllers',
], function($app) {
	$app->get('signin', ['as' => 'user/viewSignin', 'uses' => 'UserController@viewSignin']);
	$app->get('signup', ['as' => 'user/viewSignup', 'uses' => 'UserController@viewSignup']);
	
	$app->post('signin', ['as' => 'user/signin', 'uses' => 'UserController@signin']);
	$app->post('signup', ['as' => 'user/signup', 'uses' => 'UserController@signup']);
	
	$app->get('user/unique-email', 'UserController@uniqueEmail');
});

$app->group([
	'middleware' => 'auth',
	'namespace' => 'App\Http\Controllers',
], function($app) {
	$app->get('logout', ['as' => 'user/logout', 'uses' => 'UserController@logout']);
	
	$app->get('todos', ['as' => 'todo/index', 'uses' => 'TodoController@index']);
	$app->get('todos/create', ['as' => 'todo/viewCreate', 'uses' => 'TodoController@viewCreate']);
	$app->get('todos/update/{id:[0-9]+}', ['as' => 'todo/viewUpdate', 'uses' => 'TodoController@viewUpdate']);

	$app->post('todos', 'TodoController@create');
	$app->get('todos/{id:[0-9]+}', 'TodoController@read');
	$app->put('todos/{id:[0-9]+}', 'TodoController@update');

	$app->post('todo-items', 'TodoItemController@create');
	$app->put('todo-items/{id:[0-9]+}', 'TodoItemController@update');
	$app->delete('todo-items/{id:[0-9]+}', 'TodoItemController@delete');
});