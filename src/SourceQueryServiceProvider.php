<?php

namespace MoonlyDays\LaravelSourceQuery;

use Illuminate\Support\ServiceProvider;

class SourceQueryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(Service::class);
    }
}
