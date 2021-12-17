<?php

Route::group([
    'prefix'    => 'auth',
    'namespace' => 'Auth'
], function () {

    Route::post('password/reset', 'PasswordController@reset');
    Route::post('password/confirm', 'PasswordController@confirm');
});
