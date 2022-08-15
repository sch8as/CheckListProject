<?php

namespace App\Policies\Admin;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserControllerPolicy
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

    public function view(User $user)
    {
        return $user->hasRole('admin|moderator|list_limiter|list_reader');
    }

    public function updateRoles(User $user)
    {
        return $user->hasRole('admin');
    }

    public function updateStatus(User $user)
    {
        return $user->hasRole('admin|moderator');
    }

    public function updateListLimit(User $user)
    {
        return $user->hasRole('admin|list_limiter');
    }
}
