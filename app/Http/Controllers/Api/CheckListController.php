<?php

namespace App\Http\Controllers\Api;

use App\Actions\CheckList\DestroyCheckListAction;
use App\Actions\CheckList\IndexCheckListAction;
use App\Actions\CheckList\ShowCheckListAction;
use App\Actions\CheckList\StoreCheckListAction;
use App\Actions\CheckList\UpdateCheckListAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCheckListRequest;
use App\Http\Resources\CheckElementResourceCollection;
use App\Http\Resources\CheckListResource;
use App\Http\Resources\CheckListResourceCollection;

class CheckListController extends Controller
{
    public function index(IndexCheckListAction $action)
    {
        $checkLists = $action->execute();
        return response()->json([
            'state' => true,
            'check_lists' => new CheckListResourceCollection($checkLists)
        ]);
    }

    public function show($id, ShowCheckListAction $action)
    {

        $checkList = $action->execute($id);
        $checkElements = $action->getCheckElements();
        return response()->json([
            'state' => true,
            'check_list' => new CheckListResource($checkList),
            'check_elements' => new CheckElementResourceCollection($checkElements)
        ]);
    }

    public function store(StoreCheckListRequest $request, StoreCheckListAction $action)
    {
        $checkList = $action->execute($request->all());

        if($action->limitIsExceeded()) {
            return response()->json([ 'state' => false, 'message' => $action->getMessage() ]);
        }

        return response()->json([
            'state' => true,
            'message' => "Check list created successfully",
            'check_list' => new CheckListResource($checkList)
        ]);
    }

    public function update(StoreCheckListRequest $request, $id, UpdateCheckListAction $action)
    {
        return response()->json([
            'state' => true,
            'message' => "Check list updated successfully",
            'check_list' => new CheckListResource($action->execute($request->all(), $id))
        ]);
    }

    public function destroy($id, DestroyCheckListAction $action)
    {
        $action->execute($id);
        return response()->json([ 'state' => true, 'message' => "Check list deleted successfully" ]);
    }
}
