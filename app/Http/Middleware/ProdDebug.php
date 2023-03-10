<?php


namespace App\Http\Middleware;

use Closure;

class ProdDebug
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
        $lastRequest = app('request')->create(url()->previous());
        // for demo use
        if ($request->input('companyid') == '7' || env("WECHAT_WORK_FLAG", false) == 'true' || $lastRequest->get("WECHAT_WORK_FLAG", false)) {
            $request->offsetSet('WECHAT_WORK_FLAG', 1);
        }
        return $next($request);
    }
}