<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Enquiry;
use App\Models\Setting;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Site settings ($S) are available in every view, managed from Admin > Settings.
        View::composer('*', function ($view) {
            static $S = null;
            if ($S === null) {
                $S = Schema::hasTable('settings') ? Setting::all_values() : [];
            }
            // catalogue: an upload from Admin > Settings wins, else the PDF kept in public/img
            $S['catalogue_url'] = ! empty($S['catalogue_pdf'])
                ? asset('storage/'.$S['catalogue_pdf'])
                : (file_exists(public_path('img/NUBIC-MCB.pdf')) ? asset('img/NUBIC-MCB.pdf') : null);
            $view->with('S', $S);
        });

        View::composer('layouts.frontend-footer', function ($view) {
            $view->with('footerCategories', Category::active()->get());
        });

        View::composer('layouts.admin', function ($view) {
            $view->with('unreadEnquiries', Enquiry::where('is_read', false)->count());
            $view->with('unreadApplications', \App\Models\JobApplication::where('is_read', false)->count());
        });
    }
}
