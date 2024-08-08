<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

use App\Model\SelpIncidentModel;
use App\Model\PollisomajDataModel;
use App\Model\SurvivorDirectServiceModel;
use App\Model\SurvivorCourtCaseModel;
use App\Model\FollowUpInfo;
use App\Model\IncidentReferral;
use App\Model\DirectServiceType;

use App\Observers\IncidentObserver;
use App\Observers\PollisomajDataObserver;
use App\Observers\DirectServiceObserver;
use App\Observers\CourtCaseObserver;
use App\Observers\FollowUpInfoObserver;
use App\Observers\IncidentReferralObserver;
use App\Observers\DirectServiceTypeObserver;
;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
        SelpIncidentModel::observe(IncidentObserver::class);
        PollisomajDataModel::observe(PollisomajDataObserver::class);
        SurvivorDirectServiceModel::observe(DirectServiceObserver::class);
        SurvivorCourtCaseModel::observe(CourtCaseObserver::class);
        FollowUpInfo::observe(FollowUpInfoObserver::class);
        IncidentReferral::observe(IncidentReferralObserver::class);
        DirectServiceType::observe(DirectServiceTypeObserver::class);
    }
}
