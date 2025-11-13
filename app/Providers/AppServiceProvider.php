<?php

namespace App\Providers;

use App\Models\Problem;
use App\Models\TaskReview;
use App\Observers\ProblemObserver;
use App\Observers\TaskReviewObserver;
use Illuminate\Support\ServiceProvider;
use BezhanSalleh\LanguageSwitch\LanguageSwitch;

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
        TaskReview::observe(TaskReviewObserver::class);

        Problem::observe(ProblemObserver::class);


        LanguageSwitch::configureUsing(function (LanguageSwitch $switch) {
            $switch
                ->locales(['ar','en']); 
        });
    }
}
