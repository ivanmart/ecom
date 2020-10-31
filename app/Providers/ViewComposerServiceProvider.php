<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Models\MenuItem;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function boot()
    {

        /* menu composers*/

        View::composer(['main', 'catalog', 'detail', 'cart', 'order*', 'complete', 'pages.*'], function ($view) {
            $view->with('top_menu', MenuItem::where(['parent_id' => 1])->orderBy('lft')->get());
        });

        View::composer('catalog', function ($view) {
            $view->with('catalog_menu', MenuItem::where(['parent_id' => 2])->orderBy('lft')->get());
        });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
