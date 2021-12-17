<?php

Route::group([
    'prefix'    => 'auth',
    'namespace' => 'Auth'
], function () {

    Route::get('verify', 'LoginController@verify');
    Route::post('login', 'LoginController@login');
});

Route::group([
    'prefix'     => 'auth',
    'namespace'  => 'Auth',
    'middleware' => ['jwt.auth']
], function () {

    Route::post('login/referrer', 'LoginController@loginByReferrer');
    Route::post('login/{user_id}', 'LoginController@loginById');
});
