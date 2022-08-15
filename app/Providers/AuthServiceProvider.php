<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\CheckListController as AdminCheckListController;
use App\Policies\Admin\UserControllerPolicy as AdminUserControllerPolicy;
use App\Policies\Admin\CheckListControllerPolicy as AdminCheckListControllerPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        AdminUserController::class => AdminUserControllerPolicy::class,
        AdminCheckListController::class =>AdminCheckListControllerPolicy::class
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
