<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;

class LanguageMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $languages = $request->getLanguages();

        if ($language = array_get($languages, 1, array_get($languages, 0))) {
            App::setLocale($language);
        }

        return $next($request);
    }
}
