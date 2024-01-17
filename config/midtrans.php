<?php
    return [
        'serverKey' => env('MIDTRANS_SERVER_KEY', null),
        'isProduction' => env('MIDTRANS_IS_PRODUCTION', false),
        'isSanitized' => env('MIDTRANS_IS_SANITIZED', true),
        'is3ds' => env('MIDTRANS_iS_3DS', true),
    ];
?>