<?php

Route::group([
    'prefix'     => 'applications/{app_id}',
    'namespace'  => 'Apps',
    'middleware' => ['jwt.auth', 'perm:apps.manage']
], function () {

    Route::get('certificate', 'CertificateController@index');
    Route::post('certificate', 'CertificateController@save');
    Route::delete('certificate', 'CertificateController@destroy');

    Route::post('certificate/media', 'CertificateMediaController@upload');
    Route::delete('certificate/media/{media_id}', 'CertificateMediaController@destroy');
});
