<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Models\App'                   => 'App\Policies\AppPolicy',
        'App\Models\AppChecklist'          => 'App\Policies\AppChecklistPolicy',
        'App\Models\AppDocument'           => 'App\Policies\AppDocumentPolicy',
        'App\Models\AppRequirement'        => 'App\Policies\AppRequirementPolicy',
        'App\Models\AppStatus'             => 'App\Policies\AppStatusPolicy',
        'App\Models\AppType'               => 'App\Policies\AppTypePolicy',
        'App\Models\AppNotification'       => 'App\Policies\AppNotificationPolicy',
        'App\Models\Board'                 => 'App\Policies\BoardPolicy',
        'App\Models\BoardProfession'       => 'App\Policies\BoardProfessionPolicy',
        'App\Models\Media'                 => 'App\Policies\MediaPolicy',
        'App\Models\Role'                  => 'App\Policies\RolePolicy',
        'App\Models\Submission'            => 'App\Policies\SubmissionPolicy',
        'App\Models\SubmissionDocument'    => 'App\Policies\SubmissionDocumentPolicy',
        'App\Models\SubmissionRequirement' => 'App\Policies\SubmissionRequirementPolicy',
        'App\Models\Supervisor'            => 'App\Policies\SupervisorPolicy',
        'App\Models\User'                  => 'App\Policies\UserPolicy',
        'App\Models\UserActivityType'      => 'App\Policies\UserActivityTypePolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        //
    }
}
