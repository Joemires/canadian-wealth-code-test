<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class VerifyWebhookSignature
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Is Paystack
        if ($request->path() == 'webhook/paystack') {
            // only a post with paystack signature header gets our attention
            if ((!$request->isMethod('post')) || !$request->header('HTTP_X_PAYSTACK_SIGNATURE', null)) {
                throw new AccessDeniedHttpException("Invalid Request");
            }

            // Retrieve the request's body and parse it as JSON
            $input = $request->getContent();

            // validate event do all at once to avoid timing attack
            if ($request->header('HTTP_X_PAYSTACK_SIGNATURE') !== hash_hmac('sha512', $input, config('paystack.secretKey'))) {
                throw new AccessDeniedHttpException("Access Denied");
            }
        }
        return $next($request);
    }
}
