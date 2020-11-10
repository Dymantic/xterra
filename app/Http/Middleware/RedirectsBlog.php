<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Str;

class RedirectsBlog
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $going_home = Str::of($request->path())
                   ->trim('/')
                   ->match('/^[a-zA-Z]{0,2}$/')
                   ->isNotEmpty();


        if (Str::contains($request->getHost(), 'blog.') && $going_home) {
            return redirect(sprintf("%s/%s", config('app.url'), 'blog'));
        }

        return $next($request);
    }
}
