<?php

namespace App\Policies\Admin;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CheckListControllerPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function index(User $user)
    {
        //return Response::allow('allow');
        //return Response::deny('deny');
        return $user->hasRole('admin|list_reader');
    }

    public function watchAdministrationLists(User $user)
    {
        return $user->hasRole('admin');
    }
}
