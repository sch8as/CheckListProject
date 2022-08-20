<?php

namespace App\Http\Controllers\Api;

use App\Actions\DestroyCheckList;
use App\Actions\IndexCheckList;
use App\Actions\ShowCheckList;
use App\Actions\StoreCheckList;
use App\Actions\UpdateCheckList;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCheckListRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;


class CheckListController extends Controller
{

    //TODO проверить actions и web controller

    public function index(IndexCheckList $action)
    {
        $checkLists = $action->execute();
        return response()->json([ 'checkLists' => $checkLists ]);
    }

    public function show($id, ShowCheckList $action)
    {
        try {
            $checkList = $action->execute($id);
            $checkElements = $action->getCheckElements();
            return response()->json([ 'checkList' => $checkList, 'checkElements' => $checkElements ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([ 'message' => $e->getMessage() ], $e->getCode());
        }
    }

    //TODO поправить остальные методы
    public function store(StoreCheckListRequest $request, StoreCheckList $action)
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

    public function update(StoreCheckListRequest $request, $id, UpdateCheckList $action)
    {
        try {
            return response()->json([
                'message' => "Check list updated successfully",
                'checkList' => $action->execute($request->all(), $id)
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([ 'message' => $e->getMessage() ], $e->getCode());
        }
    }

    public function destroy($id, DestroyCheckList $action)
    {
        try {
            $action->execute($id);
            return response()->json([ 'message' => "Check list deleted successfully" ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([ 'message' => $e->getMessage() ], $e->getCode());
        }
    }
}
