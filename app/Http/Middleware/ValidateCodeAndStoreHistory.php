<?php

namespace App\Http\Middleware;

use App\Models\ShortLink;
use App\Models\ShortLinkHistory;
use Closure;
use Cache;
use Illuminate\Http\Request;

class ValidateCodeAndStoreHistory
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $code = ShortLink::where('code', request('code'))->first();
        if ($code) {
            $this->addHistory($code, $request);
        } else {
            abort(404);
        }
        return $next($request);
    }

    public function addHistory($code, Request $request)
    {
        $unique = env('UNIQUE_LINKS', false);
        if ($unique) {
            $history = ShortLinkHistory::firstOrCreate([
                'code_id' => $code->id,
                'ip_address' => $request->ip(),
            ]);
        } else {
            $history = ShortLinkHistory::create([
                'code_id' => $code->id,
                'ip_address' => $request->ip(),
            ]);
        }
        //Cache::forget('code_history'.$code->code);
        ShortLink::forgetCaches('links');
        ShortLink::forgetCaches('code_history'.$code->code);
    }
}
