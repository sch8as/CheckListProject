<?php

namespace App\Http\Controllers\Api;

use App\Actions\CheckElement\DestroyCheckElementAction;
use App\Actions\CheckElement\StoreCheckElementAction;
use App\Actions\CheckElement\UpdateCheckedCheckElementAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCheckElementRequest;
use App\Http\Requests\UpdateCheckedCheckElementRequest;

class CheckElementController extends Controller
{
    public function store(StoreCheckElementRequest $request, StoreCheckElementAction $action)
    {
        return response()->json([
            'message' => "Check element created successfully",
            'check_element' => $action->execute($request->all())
        ]);
    }

    public function updateChecked(UpdateCheckedCheckElementRequest $request, $id, UpdateCheckedCheckElementAction $action)
    {
        return response()->json([
            'message' => "Check element updated successfully",
            'check_element' => $action->execute($request->all(), $id)
        ]);
    }

    public function destroy($id, DestroyCheckElementAction $action)
    {
        $action->execute($id);
        return response()->json([ 'message' => "Check element deleted successfully"]);
    }
}
