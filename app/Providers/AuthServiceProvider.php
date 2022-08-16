<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\CheckListController;
use App\Http\Controllers\Admin\CheckListController as AdminCheckListController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Policies\CheckListControllerPolicy;
use App\Policies\Admin\CheckListControllerPolicy as AdminCheckListControllerPolicy;
use App\Policies\Admin\UserControllerPolicy as AdminUserControllerPolicy;


class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        CheckListController::class => CheckListControllerPolicy::class,
        AdminCheckListController::class => AdminCheckListControllerPolicy::class,
        AdminUserController::class => AdminUserControllerPolicy::class,
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
