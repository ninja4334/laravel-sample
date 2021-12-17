<?php

Route::group([
    'prefix'     => 'applications/{app_id}',
    'namespace'  => 'Apps',
    'middleware' => ['jwt.auth']
], function () {
    
    Route::get('checklist', 'ChecklistController@index')->middleware('ability:member,apps.manage|submissions.view|submissions.manage');
    Route::post('checklist', 'ChecklistController@store')->middleware('perm:apps.manage');
    Route::put('checklist/{checklist_id}', 'ChecklistController@update')->middleware('perm:apps.manage');
    Route::delete('checklist/{checklist_id}', 'ChecklistController@destroy')->middleware('perm:apps.manage');
});
