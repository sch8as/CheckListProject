<?php

namespace App\Policies;

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

    public function haveUnlimitedLists(User $user)
    {
        return $user->hasRole('admin|moderator|list_limiter|list_reader');
    }
}
