<?php

Route::group([
    'namespace' => 'Common'
], function () {

    Route::get('states', 'StateController@index');
});
