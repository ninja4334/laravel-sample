<?php

Route::group([
    'prefix'     => 'applications/{app_id}',
    'namespace'  => 'Apps',
    'middleware' => ['jwt.auth']
], function () {

    Route::get('activity', 'ActivityController@index')->middleware('ability:member,apps.manage|submissions.view|submissions.manage');
    Route::post('activity', 'ActivityController@save')->middleware('perm:apps.manage');
    Route::delete('activity', 'ActivityController@destroy')->middleware('perm:apps.manage');
});
