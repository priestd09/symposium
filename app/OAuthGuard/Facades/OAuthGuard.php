<?php

namespace App\OAuthGuard\Facades;

use Illuminate\Support\Facades\Facade;

class OAuthGuard extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'OAuthGuard';
    }
}
