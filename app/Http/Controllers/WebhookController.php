<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Middleware\VerifyWebhookSignature;

class WebhookController extends Controller
{
    public function __construct()
    {
        $this->middleware(VerifyWebhookSignature::class);
    }

    public function paystack(Request $request)
    {
        // Retrieve the request's body and parse it as JSON
        $event = collect(json_decode($request->getContent(), true))->recursive();

        // http_response_code(200); // PHP 5.4 or greater
        $response = collect(Http::withToken(config('paystack.secretKey'))->acceptJson()->get('https://api.paystack.co/transaction/verify/' . $event->pull('data.reference'))->json())->recursive();

        switch ($event->get('event')) {
            case 'charge.success':
                if($response->get('status') && Str::of($response->get('message'))->is('Verification successful')) {
                    $amount = ((float) $response->pull('data.requested_amount')) / 100;
                    if($amount == env('SUBSCRIPTION_FEE', 100)) {
                        // Make User Pro
                        $user = User::find($event->pull('data.customer.meta.user_id'));
                        $user->assignRole('premium member');
                    }
                }
                break;

            default:
                # code
                break;
        }

        return response('Webhook Handled', 200);
    }
}
