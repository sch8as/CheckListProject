<?php

namespace App\Http\Controllers;

use App\Actions\DestroyCheckList;
use App\Actions\IndexCheckList;
use App\Actions\ShowCheckList;
use App\Actions\StoreCheckList;
use App\Actions\UpdateCheckList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $checkElements = $action->getCheckElements();
        return view('check_list/show', compact('checkList', 'checkElements'));
    }

    public function create()
    {
        return view('check_list.create');
    }

    public function store(Request $request, StoreCheckList $action)
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

    public function update(Request $request, $id, UpdateCheckList $action)
    {
        $action->execute($request->all(), $id);
        return redirect()->route('lists.index');
    }

    public function destroy($id, DestroyCheckList $action)
    {
        $action->execute($id);
        return redirect()->route('lists.index');
    }
}
