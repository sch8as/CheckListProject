<?php

namespace App\Http\Controllers\Api;

use App\Actions\DestroyCheckElement;
use App\Actions\StoreCheckElement;
use App\Actions\UpdateCheckedCheckElement;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCheckElementRequest;
use App\Http\Requests\UpdateCheckedCheckElementRequest;

class CheckElementController extends Controller
{
    public function store(StoreCheckElementRequest $request, StoreCheckElement $action)
    {
        return response()->json([
            'message' => "Check element created successfully",
            'checkElement' => $action->execute($request->all())
        ]); //TODO Переписать все подобным образом, убрать поля и методы в Action
    }

    public function updateChecked(UpdateCheckedCheckElementRequest $request, $id, UpdateCheckedCheckElement $action)
    {
        return response()->json([
            'message' => "Check element updated successfully",
            'checkElement' => $action->execute($request->all(), $id)
        ]);
    }

    public function destroy($id, DestroyCheckElement $action)
    {
        $action->execute($id);
        return response()->json([ 'message' => "Check element deleted successfully"]);
    }
}
