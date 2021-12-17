<?php

/**
 * For guests.
 */
Route::group([
    'prefix'    => 'auth',
    'namespace' => 'Auth'
], function () {

    /**
     * Login
     */
    Route::get('verify', 'LoginController@verify');
    Route::post('login', 'LoginController@login');
    Route::post('login/referrer', 'LoginController@loginByReferrer');
    Route::post('login/{user_id}', 'LoginController@loginById');


    /**
     * Registration
     */
    Route::post('registration_member', 'RegistrationController@registerMember');
    Route::post('registration_board', 'RegistrationController@registerBoard');
    Route::get('registration_confirm/{token}', 'RegistrationController@confirm');


    /**
     * Reset password
     */
    Route::post('password/reset', 'PasswordController@reset');
    Route::post('password/reset_confirm', 'PasswordController@confirm');
});


/**
 * For authenticated users.
 */
Route::group([
    'namespace'  => 'Auth',
    'middleware' => ['jwt.auth']
], function () {

    /**
     * Create password
     */
    Route::post('users/{user_id}/create_password', 'PasswordController@store')
        ->middleware('perm:boards.users.manage');
});
