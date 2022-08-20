<?php

namespace App\Http\Controllers\Api;

use App\Actions\CheckList\DestroyCheckListAction;
use App\Actions\CheckList\IndexCheckListAction;
use App\Actions\CheckList\ShowCheckListAction;
use App\Actions\CheckList\StoreCheckListAction;
use App\Actions\CheckList\UpdateCheckListAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCheckListRequest;

class CheckListController extends Controller
{

    //TODO проверить actions и web controller

    public function index(IndexCheckListAction $action)
    {
        $checkLists = $action->execute();
        return response()->json([ 'checkLists' => $checkLists ]);
    }

    public function show($id, ShowCheckListAction $action)
    {

        $checkList = $action->execute($id);
        $checkElements = $action->getCheckElements();
        return response()->json([ 'checkList' => $checkList, 'checkElements' => $checkElements ]);
    }

    //TODO поправить остальные методы
    public function store(StoreCheckListRequest $request, StoreCheckListAction $action)
    {
        $checkList = $action->execute($request->all());

        if($action->limitIsExceeded()) {
            return response()->json([ 'message' => $action->getMessage() ]);
        }

        return response()->json([
            'message' => "Check list created successfully",
            'checkList' => $checkList
        ]);
    }

    public function update(StoreCheckListRequest $request, $id, UpdateCheckListAction $action)
    {
        return response()->json([
            'message' => "Check list updated successfully",
            'checkList' => $action->execute($request->all(), $id)
        ]);
    }

    public function destroy($id, DestroyCheckListAction $action)
    {
        $action->execute($id);
        return response()->json([ 'message' => "Check list deleted successfully" ]);
    }
}
