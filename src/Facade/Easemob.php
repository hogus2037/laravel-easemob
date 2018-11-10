<?php

namespace Hogus\LaravelEasemob\Facade;

use Illuminate\Support\Facades\Facade;

class Easemob extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'easemob';
    }
}
