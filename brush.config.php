<?php

return [
    'input' => 'resources/css/main.css',
    'output' => 'public/style.css',

    'scan' => [
        'resources/views'
    ],

    'theme' => [
        'spacing' => [
            '1' => '0.25rem',
            '2' => '0.5rem',
            '3' => '1rem',
            '4' => '1.5rem',
            '5' => '2rem',
        ],
        'colors' => [
            'red' => [
                '500' => '#ef4444'
            ],
            'blue' => [
                '500' => '#3b82f6'
            ]
        ],
        'breakpoints' => [
            'md' => '768px',
            'lg' => '1024px'
        ]
    ],

    'minify' => true
];
