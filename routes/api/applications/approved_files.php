<?php

Route::group([
    'prefix'     => 'applications/{app_id}',
    'namespace'  => 'Apps',
    'middleware' => ['jwt.auth', 'perm:apps.manage']
], function () {

    Route::get('approved_files', 'ApprovedFileController@index');
    Route::post('approved_files', 'ApprovedFileController@upload');
    Route::delete('approved_files/{file_id}', 'ApprovedFileController@destroy');
});
