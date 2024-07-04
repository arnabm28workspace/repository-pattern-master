<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Collection;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('site.partials.footer', function ($view) {

            $view->with('mostSearchedContent',\App\Models\AdSearchHistory::fetchMostSearchedContent());
        });

        View::composer('site.partials.sidebar', function ($view) {

                $view->with('count_unread_messages',\App\Models\User::countUnreadMessages());
            });
        
        View::composer('site.app', function ($view) {
            $site_name = \App\Models\Setting::get('site_name') == ''?config('app.name'):\App\Models\Setting::get('site_name');
            $view->with('site_name',$site_name);
        });
        View::composer('admin.app', function ($view) {
            $site_name = \App\Models\Setting::get('site_name') == ''?config('app.name'):\App\Models\Setting::get('site_name');
            $view->with('site_name',$site_name);
        });
        View::composer('auth.login', function ($view) {
            $site_name = \App\Models\Setting::get('site_name') == ''?config('app.name'):\App\Models\Setting::get('site_name');
            $view->with('site_name',$site_name);
        });

        if (!Collection::hasMacro('paginate')) {

            Collection::macro('paginate', 
                function ($perPage = 15, $page = null, $options = []) {
                $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
                return (new LengthAwarePaginator(
                    $this->forPage($page, $perPage), $this->count(), $perPage, $page, $options))
                    ->withPath('');
            });
        }
    }
}
