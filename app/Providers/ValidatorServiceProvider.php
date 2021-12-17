<?php

namespace App\Providers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class ValidatorServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('app_reviewer_exists', 'App\Validators\AppValidator@validateReviewerExists');

        Validator::extend('check_password', 'App\Validators\PasswordValidator@validatePassword');

        Validator::extend('media', 'App\Validators\MediaValidator@validateMedia');
        Validator::replacer('media', 'App\Validators\MediaValidator@replacerMedia');

        Validator::extend('spreadsheet', 'App\Validators\XLSFileValidator@validate');
        Validator::replacer('spreadsheet', 'App\Validators\XLSFileValidator@replacer');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
