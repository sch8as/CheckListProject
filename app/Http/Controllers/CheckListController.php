<?php

namespace App\Http\Controllers;

use App\Models\CheckList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckListController extends Controller
{
    public function index()
    {
        $checkLists = Auth::user()->checkLists()->orderBy('title')->get();
        return view('check_list.index', compact('checkLists'));
    }

    public function show($id)
    {
        $checkList = Auth::user()->checkLists()->findOrFail($id);
        $checkElements = $checkList->checkElements()->get();
        return view('check_list/show', compact('checkList', 'checkElements'));
    }

    public function create()
    {
        return view('check_list.create');
    }

    public function store(CheckList $checkListModel, Request $request)
    {
        $limit = Auth::user()->checklist_limit;
        $listsCount = Auth::user()->checkLists()->count();

        if($listsCount >= $limit) {
            if(!Auth::user()->hasRole('admin|moderator|list_reader|list_limiter')) {
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
        $list = Auth::user()->checkLists()->findOrFail($id);
        return view('check_list.edit', compact('list'));
    }

    public function update(Request $request, $id)
    {
        $list = Auth::user()->checkLists()->findOrFail($id);
        $list->title=$request->title;
        $list->description=$request->description;
        $list->save();
        return redirect()->route('lists.index');
    }

    public function destroy($id)
    {
        $list = Auth::user()->checkLists()->findOrFail($id);
        $list->delete();
        return redirect()->route('lists.index');
    }
}
