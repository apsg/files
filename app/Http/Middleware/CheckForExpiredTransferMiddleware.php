<?php
namespace App\Http\Middleware;

use App\Exceptions\AccessExpiredException;
use App\Models\Transfer;
use Illuminate\Http\Request;

class CheckForExpiredTransferMiddleware
{
    public function handle(Request $request, callable $next)
    {
        /** @var Transfer $transfer */
        $transfer = $request->route('transfer');

        if ($transfer === null) {
            throw new AccessExpiredException();
        }

        if ($transfer->expires_at !== null && $transfer->expires_at->isPast()) {
            throw new AccessExpiredException();
        }

        return $next($request);
    }
}
