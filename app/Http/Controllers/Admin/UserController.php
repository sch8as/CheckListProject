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

        $this->checkCurrentUserCanControl($user);

        return view('admin.users.show', compact('user'));
    }

    public function updateRoles(Request $request, $id)
    {
        $roles = [];

        $user = User::find($id);

        $this->checkCurrentUserCanControl($user);

        $user->roles()->detach();

        //Поправить это безобразие
        if($request->is_admin)
            $roles[] = 'admin';
        if($request->is_moderator)
            $roles[] = 'moderator';
        if($request->is_list_reader)
            $roles[] = 'list_reader';
        if($request->is_list_limiter)
            $roles[] = 'list_limiter';

        $user->assignRole($roles);

        return redirect()->route('users.show', ['user' => $id]);
    }

    public function updateStatus(Request $request, $id)
    {
        $user = User::find($id);

        $this->checkCurrentUserCanControl($user);

        $user->status=($request->is_banned == 'on')?(0):(1);
        $user->save();

        return redirect()->route('users.show', ['user' => $id]);
    }

    public function updateListLimit(Request $request, $id)
    {
        $user = User::find($id);

        $this->checkCurrentUserCanControl($user);

        $user->checklist_limit=$request->checklist_limit;
        $user->save();

        return redirect()->route('users.show', ['user' => $id]);
    }

    //Не уверен, можно ли помещать в контроллере данный метод
    private function checkCurrentUserCanControl($user)
    {
        if(!Auth::user()->hasRole('admin')) {
            if($user->hasRole('admin|moderator|list_reader|list_limiter')) {
                abort(403);
            }
        }
        /*if(!Auth::user()->hasRole('admin|moderator|list_reader|list_limiter')) {
            abort(403);
        }*/
    }


}
