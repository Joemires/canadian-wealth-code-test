<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PanelController extends Controller
{
    public function overview(Request $request)
    {
        if(optional(auth()->user())->hasRole('admin')) return redirect()->route('backend.users.index');

        $request->user()->transactions()->create([
            'amount' => 500,
            'reference' => 'xyz-123456'
        ]);
        return view('backend.overview');

    }

    public function premium(Request $request)
    {
        if($request->isMethod('post')) {
            $user = auth()->user();

            $response = collect(Http::withToken(config('paystack.secretKey'))->acceptJson()->get('https://api.paystack.co/transaction/verify/' . $request->input('reference'))->json())->recursive();
            // ds($response);

            if($response->get('status') && Str::of($response->get('message'))->is('Verification successful')) {
                $amount = ((float) $response->pull('data.requested_amount')) / 100;
                if($amount == env('SUBSCRIPTION_FEE', 100)) {
                    // Make User Pro
                    $request->user()->assignRole('premium member');

                    $request->user()->transactions()->create([
                        'amount' => $amount,
                        'reference' => $request->input('reference'),
                        'meta' => [
                            'reaseon' => 'premium_subscription'
                        ]
                    ]);

                    return response()->json(['error' => false]);
                }
            }
            return response()->json(['error' => true]);
        }
    }
}
