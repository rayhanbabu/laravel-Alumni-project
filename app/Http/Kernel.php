<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array<int, class-string|string>
     */
    protected $middleware = [
        // \App\Http\Middleware\TrustHosts::class,
        \App\Http\Middleware\TrustProxies::class,
        \Illuminate\Http\Middleware\HandleCors::class,
        \App\Http\Middleware\PreventRequestsDuringMaintenance::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array<string, array<int, class-string|string>>
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'api' => [
            // \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            \Illuminate\Routing\Middleware\ThrottleRequests::class.':api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];

    /**
     * The application's middleware aliases.
     *
     * Aliases may be used instead of class names to conveniently assign middleware to routes and groups.
     *
     * @var array<string, class-string|string>
     */
    protected $middlewareAliases = [
        'DuClubAccess' => \App\Http\Middleware\DuClubAccess::class,
        'AlumniMemberToken' => \App\Http\Middleware\AlumniMemberToken::class,
        'AlumniTokenExist' => \App\Http\Middleware\AlumniTokenExist::class,
        'AlumniToken' => \App\Http\Middleware\AlumniToken::class,
        'DuClubToken' => \App\Http\Middleware\DuClubToken::class,
        'AdminAccess' => \App\Http\Middleware\AdminAccess::class,
        'AdminViewAccess' => \App\Http\Middleware\AdminViewAccess::class,
        'AdminEditAccess' => \App\Http\Middleware\AdminEditAccess::class,
        'IssueViewAccess' => \App\Http\Middleware\IssueViewAccess::class,
        'IssueEditAccess' => \App\Http\Middleware\IssueEditAccess::class,
        'PaymentViewAccess' => \App\Http\Middleware\PaymentViewAccess::class,
        'PaymentEditAccess' => \App\Http\Middleware\PaymentEditAccess::class,
        'ForgetTokenExist' => \App\Http\Middleware\ForgetTokenExist::class,
        'ForgetToken' => \App\Http\Middleware\ForgetToken::class,
        'MaintainTokenExist' => \App\Http\Middleware\MaintainTokenExist::class,
        'MaintainToken' => \App\Http\Middleware\MaintainToken::class,
        'AdminIs' => \App\Http\Middleware\AdminIs::class,
        'auth' => \App\Http\Middleware\Authenticate::class,
        'MaintainIs' => \App\Http\Middleware\MaintainIs::class,
        'auth' => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'auth.session' => \Illuminate\Session\Middleware\AuthenticateSession::class,
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
        'precognitive' => \Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests::class,
        'signed' => \App\Http\Middleware\ValidateSignature::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
    ];
}
