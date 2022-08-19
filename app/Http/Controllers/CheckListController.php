<?php

namespace App\Http\Controllers;

use App\Models\CheckList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Actions\IndexCheckList;
use App\Actions\ShowCheckList;
use App\Actions\StoreCheckList;
use App\Actions\UpdateCheckList;
use App\Actions\DestroyCheckList;

class CheckListController extends Controller
{
    public function index(IndexCheckList $action)
    {
        $checkLists = $action->execute();
        return view('check_list.index', compact('checkLists'));
    }

    public function show($id, ShowCheckList $action)
    {
        $checkList = $action->execute($id);
        if($action->IsFailed()) { abort(404); }
        $checkElements = $action->getCheckElements();
        return view('check_list/show', compact('checkList', 'checkElements'));
    }

    public function create()
    {
        return view('check_list.create');
    }

    public function store(CheckList $checkListModel, Request $request, StoreCheckList $action)
    {
        $action->execute($request->all());

        if($action->IsFailed()) {
            $message = $action->getMessage();
            return view('check_list.create', compact('message'));
        }

        return redirect()->route('lists.index');
    }

    public function edit($id)
    {
        $list = Auth::user()->checkLists()->findOrFail($id);
        return view('check_list.edit', compact('list'));
    }

    public function update(Request $request, $id, UpdateCheckList $action)
    {
        $action->execute($request->all(), $id);
        if($action->IsFailed()) { abort(404); }
        return redirect()->route('lists.index');
    }

    public function destroy($id, DestroyCheckList $action)
    {
        $action->execute($id);
        if($action->IsFailed()) { abort(404); }
        return redirect()->route('lists.index');
    }
}
