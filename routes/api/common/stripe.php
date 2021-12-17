<?php

Route::group([
    'namespace'  => 'Common'
], function () {

    Route::post('stripe/webhook', 'StripeWebhookController@handleWebhook');
});
