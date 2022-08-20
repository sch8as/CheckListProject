<?php

namespace App\Http\Controllers;

use App\Actions\CheckList\DestroyCheckListAction;
use App\Actions\CheckList\IndexCheckListAction;
use App\Actions\CheckList\ShowCheckListAction;
use App\Actions\CheckList\StoreCheckListAction;
use App\Actions\CheckList\UpdateCheckListAction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckListController extends Controller
{
    public function index(IndexCheckListAction $action)
    {
        $checkLists = $action->execute();
        return view('check_list.index', compact('checkLists'));
    }

    public function show($id, ShowCheckListAction $action)
    {
        $checkList = $action->execute($id);
        $checkElements = $action->getCheckElements();
        return view('check_list/show', compact('checkList', 'checkElements'));
    }

    public function create()
    {
        return view('check_list.create');
    }

    public function store(Request $request, StoreCheckListAction $action)
    {
        $action->execute($request->all());

        if($action->limitIsExceeded()) {
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

    public function update(Request $request, $id, UpdateCheckListAction $action)
    {
        $action->execute($request->all(), $id);
        return redirect()->route('lists.index');
    }

    public function destroy($id, DestroyCheckListAction $action)
    {
        $action->execute($id);
        return redirect()->route('lists.index');
    }
}
