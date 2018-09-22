<?php
return [
    'shop' => [
        'shipping_prices' => [
            [
                'from' => 0,
                'to' => 250,
                'cost' => 4.95
            ],
            [
                'from' => 251,
                'to' => 509,
                'cost' => 6.15
            ],
            [
                'from' => 510,
                'to' => 1000,
                'cost' => 8
            ],
            [
                'from' => 1101,
                'to' => 3000,
                'cost' => 10
            ]
        ],
        'storage_prices' => [
            8 => 0,
            16 => 2.55,
            32 => 3.55
        ]
    ]
];