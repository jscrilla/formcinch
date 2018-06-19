<?php

Route::group([
	'prefix'     => config('formcinch.formcinch.form_admin_prefix', 'form-cinch'),
	'middleware' => ['web', config('formcinch.formcinch.middleware_key', 'form-cinch-admin')],
	'namespace'  => 'Ngmedia\FormCinch\Controllers',
], function () { // custom admin routes
	Route::get('/', 'FormCinchAdminController@index');
	Route::get('/new', 'FormCinchAdminController@create');
	Route::post('/new', 'FormCinchController@store');
	Route::get('/{id}/edit', 'FormCinchController@edit');
	Route::put('/{id}/edit', 'FormCinchController@update');
	Route::get('{slug}/results', 'FormCinchAdminController@show');
}); // this should be the absolute last line of this file