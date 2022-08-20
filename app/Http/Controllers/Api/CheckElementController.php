<?php

namespace App\Http\Controllers\Api;

use App\Actions\DestroyCheckElement;
use App\Actions\StoreCheckElement;
use App\Actions\UpdateCheckedCheckElement;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCheckElementRequest;
use App\Http\Requests\UpdateCheckedCheckElementRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CheckElementController extends Controller
{
    public function store(StoreCheckElementRequest $request, StoreCheckElement $action)
    {
        try {
            return response()->json([
                'message' => "Check element created successfully",
                'checkElement' => $action->execute($request->all())
            ]);
        } catch (ModelNotFoundException $e) { //TODO Переписать все подобным образом, убрать поля и методы в Action
            return response()->json([ 'message' => $e->getMessage() ], $e->getCode());
        }
    }

    public function updateChecked(UpdateCheckedCheckElementRequest $request, $id, UpdateCheckedCheckElement $action)
    {
        try {
            return response()->json([
                'message' => "Check element updated successfully",
                'checkElement' => $action->execute($request->all(), $id)
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([ 'message' => $e->getMessage() ], $e->getCode());
        }
    }

    public function destroy($id, DestroyCheckElement $action)
    {
        try {
            $action->execute($id);
            return response()->json([ 'message' => "Check element deleted successfully"]);
        } catch (ModelNotFoundException $e) {
            return response()->json([ 'message' => $e->getMessage() ], $e->getCode());
        }
    }
}
