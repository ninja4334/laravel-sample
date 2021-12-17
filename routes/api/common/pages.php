<?php

Route::group([
    'namespace'  => 'Common',
    'middleware' => ['jwt.auth', 'perm:pages.manage']
], function () {

    Route::get('pages', 'PageController@index');
    Route::get('pages/{page_id}', 'PageController@show');
    Route::post('pages', 'PageController@store');
    Route::put('pages/{page_id}', 'PageController@update');
    Route::delete('pages/{page_id}', 'PageController@destroy');
});
