<?php

Route::group([
    'namespace'  => 'Apps',
], function () {

    Route::get('applications/{app_id}', 'AppController@show');
});
