<?php
return [
    // "paysafecard" => [
    // 	"api_key" => $_ENV['PAYSAFECARD_API_KEY'],
    // 	'testing_mode' => true,
    // 	'urls' => [
    // 		$_ENV['PAYSAFECARD_SUCCESS_URL'],
    // 		$_ENV['PAYSAFECARD_FAILURE_URL'],
    // 		$_ENV['PAYSAFECARD_NOTIFICATION_URL']
    // 	]
    // ],
    "stripe" => [
        "is_test" => ($_ENV['STRIPE_IS_TEST'] ? true : false),
        "public" => $_ENV['STRIPE_PUBLIC'],
        "private" => $_ENV['STRIPE_PRIVATE'],
        "return_redirect_url" => $_ENV['WEB_ENDPOINT'] . "/shop/checkout/success",
        "cancel_redirect_url" => $_ENV['WEB_ENDPOINT'] . "/shop/checkout/payment",
        "webhook_secret" => $_ENV['STRIPE_WEBHOOK_SECRET']
    ],
    "staileu" => [
        "public" => $_ENV['STAILEU_PUBLIC'],
        "private" => $_ENV['STAILEU_PRIVATE'],
        "redirect" => $_ENV['STAILEU_REDIRECT']
    ],
    "paypal" => [
        "public" => $_ENV['PAYPAL_PUBLIC'],
        "private" => $_ENV['PAYPAL_PRIVATE'],
        "return_redirect_url" => $_ENV['WEB_ENDPOINT'] . "/shop/checkout/paypal-execute",
        "cancel_redirect_url" => $_ENV['WEB_ENDPOINT'] . "/shop/checkout/payment"
    ],
    "jwt" => [
        "key" => $_ENV['JWT_KEY']
    ],
    "account" => [
        "redirection_url_cookie" => "login_redirection_url",
        "jwt_cookie" => "user_token"
    ],
    "la_poste" => [
        "key" => $_ENV['LA_POSTE_KEY']
    ]
];