<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCheckListRequest;
use App\Models\CheckList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckListController extends Controller
{

    public function index()
    {
        //dd(Auth::user());
        $checkLists = Auth::user()->checkLists()->orderBy('title')->get();
        //$checkLists = CheckList::orderBy('title')->get();
        return response()->json([
            'status' => 200,
            'checkLists' => $checkLists
        ]);
    }

    public function show($id)
    {
        $checkList = Auth::user()->checkLists()->find($id);

        if(!$checkList) {
            return response()->json([
                'status' => false,
                'message' => "Check list not found"
            ], 404);
        }

        $checkElements = $checkList->checkElements()->get();
        //return view('check_list/show', compact('checkList', 'checkElements'));
        return response()->json([
            'status' => 200,
            'checkList' => $checkList,
            'checkElements' => $checkElements
        ]);
    }

    public function store(StoreCheckListRequest $request)
    {
        //dd($request->all());

        $limit = Auth::user()->checklist_limit;
        $listsCount = Auth::user()->checkLists()->count();


        if((!Auth::user()->can('have-unlimited-lists', [self::class])) && $listsCount >= $limit) {
            $message = "Limit (" . $limit . ") is exceeded. The list cannot be added.";
            return response()->json([
                'status' => false,
                'message' => $message
            ], 403);
        }

        $currentUserId = ["user_id" => Auth::id()];
        //$currentUserId = ["user_id" => 1];
        $newCheckList = array_merge($request->all(), $currentUserId);

        $checkList =  CheckList::create($newCheckList);
        return response()->json([
            'status' => true,
            'message' => "Check list created successfully",
            'checkList' => $checkList
        ], 200);
    }

    public function update(StoreCheckListRequest $request, $id)
    {
        $checkList = Auth::user()->checkLists()->find($id);
        if(!$checkList) {
            return response()->json([
                'status' => false,
                'message' => "Check list not found"
            ], 404);
        }

        $checkList->update($request->all());
        return response()->json([
            'status' => true,
            'message' => "Check list updated successfully",
            'checkList' => $checkList
        ], 200);
    }

    public function destroy($id)
    {
        $checkList = Auth::user()->checkLists()->find($id);
        if(!$checkList) {
            return response()->json([
                'status' => false,
                'message' => "Check list not found"
            ], 404);
        }
        //$checkList = CheckList::findOrFail($id);
        $checkList->delete();
        return response()->json([
            'status' => true,
            'message' => "Check list deleted successfully"
        ], 200);
    }
}
