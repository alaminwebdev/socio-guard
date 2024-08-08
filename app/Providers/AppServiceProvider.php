<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use App\Observers\RegionAreaDetailObserver;
use App\Model\Admin\Setup\CEP_Region\RegionAreaDetail;
use App\Model\Admin\Setup\CEP_Region\SetupUser;
use App\Model\Admin\Setup\CEP_Region\SetupUserArea;
use App\Model\PollisomajSetup;
use App\Observers\PollisomajObserver;
use App\Observers\SetupUserAreaObserver;
use App\Observers\SetupUserObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        RegionAreaDetail::observe(RegionAreaDetailObserver::class);
        SetupUser::observe(SetupUserObserver::class);
        SetupUserArea::observe(SetupUserAreaObserver::class);
        PollisomajSetup::observe(PollisomajObserver::class);

        
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        
    }
}
