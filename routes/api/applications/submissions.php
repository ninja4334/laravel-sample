<?php

Route::group([
    'prefix'     => 'applications/{app_id}',
    'namespace'  => 'Apps',
    'middleware' => ['jwt.auth', 'role:member']
], function () {

    Route::post('submissions', 'SubmissionController@store');
});
