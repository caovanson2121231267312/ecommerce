<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        'broadcasting/auth',
        'api/broadcasting/auth',
        '/sociallogin/google',
        '/sociallogin/facebook',
        '/sociallogin/github',
        '/sociallogin/twitter',
        '/sociallogin/vkontakte'
    ];
}
