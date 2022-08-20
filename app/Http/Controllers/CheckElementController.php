<?php

namespace App\Http\Controllers;

use App\Actions\CheckElement\DestroyCheckElementAction;
use App\Actions\CheckElement\StoreCheckElementAction;
use App\Actions\CheckElement\UpdateCheckedCheckElementAction;
use Illuminate\Http\Request;

class CheckElementController extends Controller
{
    public function store(Request $request, StoreCheckElementAction $action)
    {
        $action->execute($request->all());
        return redirect()->route('lists.show', ['list' => $request->check_list_id]);
        //TODO проверить при пустом значении title
    }

    public function updateChecked(Request $request, UpdateCheckedCheckElementAction $action)
    {
        $action->execute($request->all(), $request->get("id"));
    }

    public function destroy($id, DestroyCheckElementAction $action)
    {
        $checkElement = $action->execute($id);
        return redirect()->route('lists.show', ['list' => $checkElement->check_list_id]); //TODO поменять list на checkList
    }
}
