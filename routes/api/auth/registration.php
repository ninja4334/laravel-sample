<?php

Route::group([
    'prefix'    => 'auth',
    'namespace' => 'Auth'
], function () {

    Route::post('registration_board', 'RegistrationController@registerBoard');
    Route::post('registration_member', 'RegistrationController@registerMember');
    Route::post('send_confirmation', 'RegistrationController@sendConfirmation');
    Route::get('registration/confirm', 'RegistrationController@confirm');
});
