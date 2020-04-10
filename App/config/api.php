<?php
return [
	"paysafecard" => [
		"api_key" => getenv('PAYSAFECARD_API_KEY'),
		'testing_mode' => true,
		'urls' => [
			getenv('PAYSAFECARD_SUCCESS_URL'),
			getenv('PAYSAFECARD_FAILURE_URL'),
			getenv('PAYSAFECARD_NOTIFICATION_URL')
		]
	],
    "stripe" => [
        "is_test" => (getenv("STRIPE_IS_TEST") ? true : false),
        "public" => getenv("STRIPE_PUBLIC"),
        "private" => getenv("STRIPE_PRIVATE"),
        "return_redirect_url" => getenv('WEB_ENDPOINT') . "/shop/checkout/success",
        "cancel_redirect_url" => getenv('WEB_ENDPOINT') . "/shop/checkout/payment",
        "webhook_secret" => getenv('STRIPE_WEBHOOK_SECRET')
    ],
    "staileu" => [
        "public" => getenv("STAILEU_PUBLIC"),
        "private" => getenv("STAILEU_PRIVATE"),
        "redirect" => getenv("STAILEU_REDIRECT")
    ],
    "paypal" => [
        "public" => getenv('PAYPAL_PUBLIC'),
        "private" => getenv('PAYPAL_PRIVATE'),
        "return_redirect_url" => getenv('API_ENDPOINT') . "/paypal/execute",
        "cancel_redirect_url" => getenv('WEB_ENDPOINT') . "/shop/checkout/payment"
    ],
    "jwt" => [
        "key" => getenv("JWT_KEY")
    ],
    "account" => [
        "redirection_url_cookie" => "login_redirection_url",
        "jwt_cookie" => "user_token",
        "domain" => getenv("SOURCE_DOMAIN")
    ]
];