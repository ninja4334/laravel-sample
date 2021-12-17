<?php

Route::group([
    'namespace'  => 'Common',
    'middleware' => ['jwt.auth', 'perm:settings.manage']
], function () {

    Route::get('settings', 'SettingsController@index');
    Route::put('settings', 'SettingsController@update');
});


Route::group([
    'namespace'  => 'Common'
], function () {

    Route::get('settings/public', 'SettingsController@publicSettings');
});
