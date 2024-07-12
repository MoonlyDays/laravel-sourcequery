<?php

namespace MoonlyDays\LaravelSourceQuery;

use Illuminate\Support\Facades\Facade as LaravelFacade;

class Facade extends LaravelFacade
{
    protected static function getFacadeAccessor(): string
    {
        return Service::class;
    }
}
