<?php

Route::group([
    'prefix'     => 'applications/{app_id}',
    'namespace'  => 'Apps',
    'middleware' => ['jwt.auth']
], function () {

    Route::get('documents', 'DocumentController@index')->middleware('ability:member,apps.manage|submissions.view|submissions.manage');
    Route::post('documents', 'DocumentController@store')->middleware('perm:apps.manage');
    Route::put('documents/{document_id}', 'DocumentController@update')->middleware('perm:apps.manage');
    Route::delete('documents/{document_id}', 'DocumentController@destroy')->middleware('perm:apps.manage');
});
