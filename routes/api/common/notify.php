<?php

Route::group([
    'namespace'  => 'Common'
], function () {

    Route::post('notify', 'NotifyController@send');
});
