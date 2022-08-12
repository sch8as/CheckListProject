<?php

namespace App\Http\Controllers;

use App\Models\CheckElement;
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
        $query = CheckList::with('user')->with('elements');

        if(!Auth::user()->hasRole('admin'))
        {
            $query->whereHas('user', function($query) {
                $query->doesntHave('roles');
            });
        }

        $filter = '';
        if ($request->filled('filter')) {
            $filter = $request->get('filter');
            $query->where(function ($query) use ($filter) {
                $query->whereHas('user', function($query) use ($filter) {
                    $query->where('name', 'like', "%$filter%")
                        ->orWhere('email', 'like', "%$filter%");
                })->orWhere('check_lists.title', 'like', "%$filter%")->
                orWhereHas('elements', function($query) use ($filter) {
                    $query->where('title', 'like', "%$filter%");
                });
            });
        }

        $checkLists = $query->orderBy('title')->get();
        return view('admin.check_list.index', compact('checkLists', 'filter'));
    }

    public function show($id)
    {
        $checkList = CheckList::where('user_id', '=', Auth::id())->findOrFail($id);
        $checkElements = $checkList->elements()->get();
        return view('check_list/show', compact('checkList', 'checkElements'));
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
        return redirect()->route('lists.index');
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
        return redirect()->route('lists.index');
    }

    public function destroy($id)
    {
        $list = CheckList::where('user_id', '=', Auth::id())->findOrFail($id);
        $list->delete();
        return redirect()->route('lists.index');
    }
}
