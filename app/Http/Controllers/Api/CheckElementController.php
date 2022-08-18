<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCheckElementRequest;
use App\Http\Requests\UpdateCheckedCheckElementRequest;
use Illuminate\Http\Request;
use App\Models\CheckElement;
use Illuminate\Support\Facades\Auth;

class CheckElementController extends Controller
{
    public function store(StoreCheckElementRequest $request)
    {
        //dd($request->check_list_id);
        $checkList = Auth::user()->checkLists()->find($request->check_list_id);
        if(!$checkList) {
            return response()->json([
                'status' => false,
                'message' => "Check list not found"
            ], 404);
        }

        $checkElement = CheckElement::create($request->all());
        /*return redirect()->route('lists.show', ['list' => $request->check_list_id]);*/
        return response()->json([
            'status' => true,
            'message' => "Check element created successfully",
            'checkElement' => $checkElement
        ], 200);
    }

    public function updateChecked(UpdateCheckedCheckElementRequest $request, $id)
    {
        //dd($id);
        $checked = $request->get('checked');
        //dd($checked);

        $checkElement = Auth::user()->checkElements()->find($id);
        //dd($checkElement);
        if(!$checkElement) {
            return response()->json([
                'status' => false,
                'message' => "Check element not found"
            ], 404);
        }

        $checkElement->checked = $checked; //TODO Изменить на fill
        $checkElement->save();
        return response()->json([
            'status' => true,
            'message' => "Check element updated successfully",
            'checkElement' => $checkElement
        ], 200);
    }

    public function destroy($id)
    {
        $checkElement = Auth::user()->checkElements()->find($id);
        if(!$checkElement) {
            return response()->json([
                'status' => false,
                'message' => "Check element not found"
            ], 404);
        }

        $checkElement->delete();
        return response()->json([
            'status' => true,
            'message' => "Check element deleted successfully"
        ], 200);
    }
}
