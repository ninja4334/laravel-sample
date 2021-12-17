<?php

Route::group([
    'prefix'     => 'applications/{app_id}',
    'namespace'  => 'Apps',
    'middleware' => ['jwt.auth', 'perm:apps.manage']
], function () {

    Route::get('required_files', 'RequiredFileController@index');
    Route::post('required_files', 'RequiredFileController@upload');
    Route::delete('required_files/{file_id}', 'RequiredFileController@destroy');
});
