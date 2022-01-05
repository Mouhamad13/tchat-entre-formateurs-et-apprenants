<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Using class based composers...
        view()->composer(
            'layout', 'App\Http\ViewComposers\NotificationComposer'
        );
    }
    
    public function register()
    {
        //
    }
}