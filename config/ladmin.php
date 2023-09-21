<?php

return [
    'guard' => 'web',
    'middleware' => 'auth',
    'uri' => [
        'show' => 'show',
        'detail' => 'detail',
        'edit' => 'edit',
        'create' => 'create',
        'update' => 'update',
        'destroy' => 'destroy'
    ],
    'namespace' => [
        'controller' => 'App\Admin\Controllers',
        'fields' => 'App\Admin\Fields',
    ],
    'view' => [
        'prefix' => 'admin'
    ]
    // 'index' => null,
    // 'route' => [
    //     'prefix' => 'admin',
    //     'login' => 'login',
    //     'logout' => 'logout',
    //     'register' => 'register',
    //     'dashboard' => 'dashboard',
    //     'profile' => 'profile',
    //     'show' => 'show',
    //     'detail' => 'detail',
    //     'editor' => 'editor',
    //     'create' => 'create',
    //     'update' => 'update',
    //     'destroy' => 'destroy'
    // ],
    // 'path' => [
    //     'controller' => 'App\Http\Controllers\Admin',
    // ],
    // 'namespace' => [
    //     'controller' => 'App\Http\Controllers\Admin',
    // ],
    // 'auth' => [
    //     'middleware' => 'auth',
    //     'guard' => 'web',
    //     'login' => [
    //         'url' => '/login',
    //         'name' => 'login'
    //     ],
    //     'logout' => [
    //         'url' => '/logout',
    //         'name' => 'logout'
    //     ]
    // ],
    // 'dashboard' => [
    //     'show' => [
    //         'url' => '/dashboard',
    //         'name' => 'dashboard'
    //     ]
    // ],
    // 'profile' => [
    //     'show' => [
    //         'url' => '/profile',
    //         'name' => 'profile'
    //     ],
    //     'update' => [
    //         'url' => '/profile/update',
    //         'name' => 'profile.update'
    //     ],
    //     'password-update' => [
    //         'url' => '/profile/password-update',
    //         'name' => 'profile.password-update'
    //     ],
    //     'destroy' => [
    //         'url' => '/profile/destroy',
    //         'name' => 'profile.destroy'
    //     ]
    // ]
];
