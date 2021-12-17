<?php

Route::group([
    'prefix'     => 'applications/{app_id}',
    'namespace'  => 'Apps',
    'middleware' => ['jwt.auth', 'perm:apps.manage']
], function () {

    Route::get('reviewers', 'UserController@index');
    Route::post('reviewers/{user_id}', 'UserController@attach');
    Route::delete('reviewers/{user_id}', 'UserController@detach');
});
