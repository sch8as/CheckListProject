<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if(Auth::user()->hasRole('admin'))
        {
            $users = User::orderBy('name');
        }
        else
        {
            $users = User::doesntHave('roles')->orderBy('name');
        }

        $filter = '';
        if ($request->filled('filter')) {
            $filter = $request->get('filter');
            $users->where(function ($query) use ($filter) {
                $query->where('name', 'like', "%$filter%")
                    ->orWhere('email', 'like', "%$filter%");
            });
        }

        $users = $users->get();

        return view('admin.users.index', compact('users', 'filter'));
    }

    public function show($id)
    {

        $user = User::find($id);
        $user->check_can_be_controlled_by_current_user();
        return view('admin.users.show', compact('user'));
    }

    public function update_roles(Request $request, $id)
    {
        $roles = [];

        $user = User::find($id);
        $user->check_can_be_controlled_by_current_user();
        $user->roles()->detach();

        if($request->is_admin) $roles[] = 'admin';
        if($request->is_moderator) $roles[] = 'moderator';
        if($request->is_list_reader) $roles[] = 'list_reader';
        if($request->is_list_limiter) $roles[] = 'list_limiter';

        $user->assignRole($roles);

        return redirect()->to('users/show/'.$id);
    }

    public function update_status(Request $request, $id)
    {
        $user = User::find($id);
        $user->check_can_be_controlled_by_current_user();
        $user->status=($request->is_banned == 'on')?(0):(1);
        $user->save();

        return redirect()->to('users/show/'.$id);
    }

    public function update_list_limit(Request $request, $id)
    {
        $user = User::find($id);
        $user->check_can_be_controlled_by_current_user();
        $user->checklist_limit=$request->checklist_limit;
        $user->save();

        return redirect()->to('users/show/'.$id);
    }
}
