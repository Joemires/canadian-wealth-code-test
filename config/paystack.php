<?php

/*
 * This file is part of the Laravel Paystack package.
 *
 * (c) Joseph Bassey <joemires20@yahoo.com>
 */

return [
    /***
    |--------------------------------------------------------------------------
    | Paystack Keys
    |--------------------------------------------------------------------------
    |
    | The Paystack publishable key and secret key. You can get these from your Paystack dashboard.
    |
    ***/

    /**
     * Public Key From Paystack Dashboard
     *
     */
    'publicKey' => getenv('PAYSTACK_PUBLIC_KEY'),

    /**
     * Secret Key From Paystack Dashboard
     *
     */
    'secretKey' => getenv('PAYSTACK_SECRET_KEY'),

];
