<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Activities\Providers\ActivitiesServiceProvider;
use Modules\Assignments\Providers\AssignmentsServiceProvider;
use Modules\Auth\Providers\AuthServiceProvider;
use Modules\Calendar\Providers\CalendarServiceProvider;
use Modules\Countries\Providers\CountriesServiceProvider;
use Modules\Groups\Providers\GroupsServiceProvider;
use Modules\Languages\Providers\LanguagesServiceProvider;
use Modules\Main\Providers\MainServiceProvider;
use Modules\Modules\Providers\ModulesServiceProvider;
use Modules\Projects\Providers\ProjectsServiceProvider;
use Modules\Public\Providers\PublicServiceProvider;
use Modules\Record\Providers\RecordServiceProvider;
use Modules\Records\Providers\RecordsServiceProvider;
use Modules\Reports\Providers\ReportsServiceProvider;
use Modules\User\Providers\UserServiceProvider;
use Modules\Users\Providers\UsersServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->register(AuthServiceProvider::class);
        $this->app->register(UsersServiceProvider::class);
        $this->app->register(MainServiceProvider::class);
        $this->app->register(LanguagesServiceProvider::class);
        $this->app->register(ModulesServiceProvider::class);
        $this->app->register(GroupsServiceProvider::class);
        $this->app->register(UserServiceProvider::class);
        $this->app->register(PublicServiceProvider::class);
        $this->app->register(ActivitiesServiceProvider::class);
        $this->app->register(RecordServiceProvider::class);
        $this->app->register(RecordsServiceProvider::class);
        $this->app->register(ProjectsServiceProvider::class);
        $this->app->register(CalendarServiceProvider::class);
        $this->app->register(CountriesServiceProvider::class);
        $this->app->register(ReportsServiceProvider::class);
        $this->app->register(AssignmentsServiceProvider::class);

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
