<?php
namespace App\Http\Middleware;

use App\Exceptions\AccessExpiredException;
use Illuminate\Http\Request;

class AfterMiddleware
{
    public function handle(Request $request, callable $next)
    {
        try {
            return $next($request);
        } catch (AccessExpiredException $exception) {
            return redirect('/oops');
        }
    }
}
