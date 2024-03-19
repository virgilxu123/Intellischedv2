<?php

namespace App\Providers;

use App\Models\AcademicYearTerm;
use App\Models\Classroom;
use App\Models\ClassSchedule;
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
            'manage-subjects',
            'dashboard',
            'exports.export-plotted-schedules',
        ], function ($view) {
            $view->with('faculties', Faculty::orderBy('first_name')->orderBy('last_name')->get());
            $view->with('terms', Term::all());
            $view->with('days', Day::all());
            $view->with('designations', Designation::all());
            $view->with('classrooms', Classroom::all());
            $view->with('academic_year_terms', AcademicYearTerm::all()->load('academic_year', 'term'));
            $view->with('class_schedules', ClassSchedule::all());
        });
    }
}
