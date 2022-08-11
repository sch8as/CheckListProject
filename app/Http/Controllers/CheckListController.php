<?php

namespace App\Http\Controllers;

use App\Models\CheckList;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckListController extends Controller
{
    public function index()
    {
        $checkLists = CheckList::where('user_id', '=', Auth::id())->orderBy('title')->get();
        return view('check_list.index', compact('checkLists'));
    }

    public function indexAdministration(Request $request)
    {
        $filter = '';
        //group_concat не используется, потому как возможено появление строки слишком большой длинны
        /*$query = User::select('*', 'users.id as aaa', 'check_lists.title as cl_title')->selectRaw('group_concat(check_elements.title SEPARATOR  "' .'\<br\>' . '") as ce_title');*/
        $query = User::select('*', 'users.id as aaa', 'check_lists.title as cl_title', 'check_elements.title as ce_title');


        if(Auth::user()->hasRole('admin'))
        {
            $query->orderBy('name');
        }
        else
        {
            $query->doesntHave('roles')->orderBy('name');
        }

        $query->join('check_lists', 'check_lists.user_id', '=', 'users.id');
        $query->join('check_elements', 'check_elements.check_list_id', '=', 'check_lists.id');
        /*$query->groupBy('check_list_id');*/

        if ($request->filled('filter')) {
            $filter = $request->get('filter');
            $query->where(function ($query) use ($filter) {
                $query->where('name', 'like', "%$filter%")
                    ->orWhere('email', 'like', "%$filter%")
                    ->orWhere('check_lists.title', 'like', "%$filter%")
                    ->orWhere('check_elements.title', 'like', "%$filter%");
            });
        }

        $checkLists = $query->get();
        return view('admin.check_list.index', compact('checkLists', 'filter'));
    }

    public function create()
    {
        return view('check_list.create');
    }

    public function store(CheckList $checkListModel, Request $request)
    {
        $limit = Auth::user()->checklist_limit;
        $listsCount = count(CheckList::where('user_id', '=', Auth::id())->get());

        if($listsCount >= $limit)
        {
            if(!Auth::user()->hasRole('admin|moderator|list_reader|list_limiter'))
            {
                $note = "Limit (" . $limit . ") is exceeded. The list cannot be added.";
                return view('check_list.create', compact('note'));
            }
        }
        $currentUserId = array("user_id" => Auth::id());
        $request = array_merge($request->all(), $currentUserId);
        $checkListModel->create($request);
        return redirect()->route('lists_index');
    }

    public function edit($id)
    {
        $list = CheckList::where('user_id', '=', Auth::id())->findOrFail($id);
        return view('check_list.edit', compact('list'));
    }

    public function update(Request $request, $id)
    {
        $list=CheckList::where('user_id', '=', Auth::id())->findOrFail($id);
        $list->title=$request->title;
        $list->description=$request->description;
        $list->save();
        return redirect()->route('lists_index');
    }

    public function destroy($id)
    {
        $list = CheckList::where('user_id', '=', Auth::id())->findOrFail($id);
        $list->delete();
        return redirect()->route('lists_index');
    }
}
