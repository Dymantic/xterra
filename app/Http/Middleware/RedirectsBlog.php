<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Str;

class RedirectsBlog
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
        $path = str_replace(['en/', 'zh/'], '', $request->path());
        if(Str::contains($request->getHost(), 'blog.')) {
            $redirect = Str::startsWith($path, 'blog/') ? $path : 'blog/' . $path;
            return redirect(sprintf("%s/%s", config('app.url'), $redirect));
        }
        return $next($request);
    }
}
