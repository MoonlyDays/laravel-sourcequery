<?php

namespace MoonlyDays\LaravelSourceQuery\Facades;

use Illuminate\Support\Facades\Facade;
use MoonlyDays\LaravelSourceQuery\QueryFactory;

class SourceQuery extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return QueryFactory::class;
    }
}
