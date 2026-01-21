<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
// use DB;

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
        if(file_exists(storage_path('installed'))){
        if (Schema::hasTable('general_settings')) {
            $siteInfo = DB::table('general_settings')->first();
        }
        
        view()->share(['siteInfo'=> $siteInfo]);
    }
    }
}
