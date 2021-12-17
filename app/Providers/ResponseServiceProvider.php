<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Response;

class ResponseServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Response::macro('jsonSuccess', function (string $message = null, $value = null) {
            $data = compact('message');

            if ($value) {
                array_set($data, 'data', $value);
            }

            return Response::json($data);
        });
        Response::macro('jsonCreate', function ($value, string $message = null) {
            return Response::jsonSuccess($value, $message ?? trans('events.created'));
        });

        Response::macro('jsonUpdate', function ($value, string $message = null) {
            return Response::jsonSuccess($value, $message ?? trans('events.updated'));
        });

        Response::macro('jsonDelete', function (string $message = null) {
            return Response::json([
                'message' => $message ?? trans('events.deleted')
            ]);
        });

        Response::macro('jsonError', function ($value = null, int $statusCode = 500) {
            if ($value instanceof \Exception) {
                $value = $value->getMessage();
            }

            return Response::json([
                'error'   => $value ?? trans('errors.something_went_wrong'),
            ], $statusCode);
        });

        Response::macro('jsonNotFound', function ($value = null) {
            return Response::jsonError($value ?? trans('errors.not_found'), 404);
        });

        Response::macro('jsonForbidden', function ($value = null) {
            return Response::jsonError($value ?? trans('errors.permission_denied.default'), 403);
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
