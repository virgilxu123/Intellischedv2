<?php

namespace App\Providers;

use App\Models\Day;
use App\Models\Term;
use App\Models\Faculty;
use App\Models\Designation;
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
        view()->composer([
            'create-schedule',
            'manage-subjects'
        ], function ($view) {
            $view->with('faculties', Faculty::orderBy('first_name')->orderBy('last_name')->get());
            $view->with('terms', Term::all());
            $view->with('days', Day::all());
            $view->with('designations', Designation::all());
        });
    }
}
