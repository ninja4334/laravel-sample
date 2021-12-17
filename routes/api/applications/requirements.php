<?php

Route::group([
    'prefix'     => 'applications/{app_id}',
    'namespace'  => 'Apps',
    'middleware' => ['jwt.auth']
], function () {

    Route::get('requirements', 'RequirementController@index')->middleware('ability:member,apps.manage|submissions.view|submissions.manage');
    Route::post('requirements', 'RequirementController@store')->middleware('perm:apps.manage');
    Route::put('requirements/{requirement_id}', 'RequirementController@update')->middleware('perm:apps.manage');
    Route::delete('requirements/{requirement_id}', 'RequirementController@destroy')->middleware('perm:apps.manage');
});
