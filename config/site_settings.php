<?php

return [

    'home' => [
        'news' => [
            'select' => '*',
            'amount' => 10,
            'paginate' => false,
        ],
        'blog' => [
            'select' => '*',
            'amount' => 4,
            'paginate' => false,
        ],
        'portfolio' => [
            'select' => '*',
            'amount' => 3,
            'paginate' => false,
        ],
        'gallery' => [
            'select' => '*',
            'amount' => 2,
            'paginate' => false,
        ],
        'banner' => [
            'select' => '*',
            'amount' => 3,
            'paginate' => false,
        ],
    ],

    'profile' => [
        'news' => [
            'select' => '*',
            'amount' => 10,
            'paginate' => true,
        ],
        'blog' => [
            'select' => '*',
            'amount' => 4,
            'paginate' => true,
        ],
        'portfolio' => [
            'select' => '*',
            'amount' => 3,
            'paginate' => true,
        ],
        'gallery' => [
            'select' => '*',
            'amount' => 2,
            'paginate' => true,
        ],
        'banner' => [
            'select' => '*',
            'amount' => 3,
            'paginate' => false,
        ],
    ],

    'blog' => [
        'news' => [
            'select' => '*',
            'amount' => 3,
            'paginate' => false,
        ],
        'blog' => [
            'select' => '*',
            'amount' => 5,
            'paginate' => true,
        ],
        'gallery' => [
            'select' => '*',
            'amount' => 3,
            'paginate' => false,
        ],
    ],

    'gallery' => [
        'gallery' => [
            'select' => '*',
            'amount' => 4,
            'paginate' => true,
        ],
    ],

    'search' => [
        'news' => [
            'select' => '*',
            'amount' => 10,
            'paginate' => false,
        ],
        'blog' => [
            'select' => '*',
            'amount' => 10,
            'paginate' => false,
        ],
        'gallery' => [
            'select' => '*',
            'amount' => 10,
            'paginate' => false,
        ],
    ],

];
