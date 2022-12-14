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
        $this->authorize('view', [self::class]);

        $users = Auth::user()->subUsers();

        $filter = '';
        if ($request->filled('filter')) {
            $filter = $request->get('filter');
            $users->where(function ($query) use ($filter) {
                $query->where('name', 'like', "%$filter%")
                    ->orWhere('email', 'like', "%$filter%");
            });
        }

        $users = $users->orderBy('name')->get();

        return view('admin.users.index', compact('users', 'filter'));
    }

    public function show($id)
    {
        $this->authorize('view', [self::class]);

        $user = Auth::user()->subUsers()->findOrFail($id);
        return view('admin.users.show', compact('user'));
    }

    public function updateRoles(Request $request, $id)
    {
        $this->authorize('update-roles', [self::class]);

        $user = Auth::user()->subUsers()->findOrFail($id);

        $user->roles()->detach();

        $rolesWhiteList = \Spatie\Permission\Models\Role::all()->pluck('name');
        $roles = $rolesWhiteList->intersect($request->get('roles'));

        $user->assignRole($roles);

        return redirect()->route('admin.users.show', ['user' => $id]);
    }

    public function updateStatus(Request $request, $id)
    {
        $this->authorize('update-status', [self::class]);

        $user = Auth::user()->subUsers()->findOrFail($id);
        $user->status = $request->boolean('is_banned')?(User::STATUS_BANNED):(User::STATUS_OK);
        $user->save();

        return redirect()->route('admin.users.show', ['user' => $id]);
    }

    public function updateListLimit(Request $request, $id)
    {
        $this->authorize('update-list-limit', [self::class]);

        $user = Auth::user()->subUsers()->findOrFail($id);
        $user->checklist_limit = $request->checklist_limit;
        $user->save();

        return redirect()->route('admin.users.show', ['user' => $id]);
    }
}
