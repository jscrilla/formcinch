<?php
Route::group([
    'prefix'     => config('formcinch.formcinch.form_prefix', 'form'),
    'middleware' => ['web', config('formcinch.formcinch.normal_middlware', 'web')],
    'namespace'  => 'Ngmedia\FormCinch\Controllers',
], function () { // custom admin routes
    Route::get('/{slug}', 'FormCinchController@show');
    Route::post('/{slug}', 'FormCinchSubmissionController@store');
}); // this should be the absolute last line of this file

