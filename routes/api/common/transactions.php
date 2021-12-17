<?php

Route::group([
    'namespace'  => 'Common',
    'middleware' => ['jwt.auth', 'role:member']
], function () {

    Route::get('transactions', 'TransactionController@paginate');
});

Route::group([
    'namespace'  => 'Common',
], function () {

    Route::get('transactions/{transaction_id}/download', 'TransactionController@download');
});
