<?php

namespace App\Providers;

use App\Models\Setting;
use App\Models\Page;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Mengirim data ke semua view yang relevan
        View::composer([
            'layouts.public-layout',
            'layouts.partials.public-navbar',
            'layouts.partials.public-footer',
            'components.public.hero-section'
        ], function ($view) {
            $settings = Setting::firstOrCreate([]);
            $pages = Page::where('published', true)->get();

            $view->with(compact('settings', 'pages'));
        });
    }
}
