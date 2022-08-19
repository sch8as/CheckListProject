<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCheckListRequest;
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

    //TODO проверить actions и web controller

    public function index(IndexCheckList $action)
    {
        $checkLists = $action->execute();
        return response()->json([
            'status' => 200,
            'checkLists' => $checkLists
        ]);
    }

    public function show($id, ShowCheckList $action)
    {
        $checkList = $action->execute($id);
        if($action->IsFailed()) {
            return response()->json([
                'status' => false,
                'message' => $action->getMessage()
            ], 403); //TODO настроить эти коды
        }
        $checkElements = $action->getCheckElements();
        return response()->json([
            'status' => 200, //??????????
            'checkList' => $checkList,
            'checkElements' => $checkElements
        ]);
    }

    public function store(StoreCheckListRequest $request, StoreCheckList $action)
    {
        $result = $action->execute($request->all());

        if($action->IsFailed()) {
            return response()->json([
                'status' => false,
                'message' => $action->getMessage()
            ], 403);
        }

        return response()->json([
            'status' => true,
            'message' => "Check list created successfully",
            'checkList' => $result
        ], 200);
    }

    public function update(StoreCheckListRequest $request, $id, UpdateCheckList $action)
    {
        $result = $action->execute($request->all(), $id);

        if($action->IsFailed()) {
            return response()->json([
                'status' => false,
                'message' => $action->getMessage()
            ], 403);
        }

        return response()->json([
            'status' => true,
            'message' => "Check list updated successfully",
            'checkList' => $result
        ], 200);
    }

    public function destroy($id, DestroyCheckList $action)
    {
        $action->execute($id);

        if($action->IsFailed()) {
            return response()->json([
                'status' => false,
                'message' => $action->getMessage()
            ], 403);
        }

        return response()->json([
            'status' => true,
            'message' => "Check list deleted successfully"
        ], 200);
    }
}
