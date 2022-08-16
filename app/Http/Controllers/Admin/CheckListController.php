<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CheckList;
use Illuminate\Support\Facades\Auth;

class CheckListController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('index', [self::class]);

        $query = CheckList::with('user')->with('checkElements');

        if(!Auth::user()->hasRole('admin')) {
            $query->whereHas('user', function($query) {
                $query->doesntHave('roles');
            });
        }

        //Фильтрация по столбцам list->user->name, list->user->email, list->check_lists.title, list->title
        $filter = '';
        if ($request->filled('filter')) {
            $filter = $request->get('filter');
            $query->where(function ($query) use ($filter) {
                $query->whereHas('user', function($query) use ($filter) {
                    $query->where('name', 'like', "%$filter%")
                        ->orWhere('email', 'like', "%$filter%");
                })->orWhere('check_lists.title', 'like', "%$filter%")
                    ->orWhereHas('checkElements', function($query) use ($filter) {
                        $query->where('title', 'like', "%$filter%");
                });
            });
        }

        $checkLists = $query->orderBy('title')->get();
        return view('admin.check_list.index', compact('checkLists', 'filter'));
    }
}
