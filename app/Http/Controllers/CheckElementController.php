<?php

namespace App\Http\Controllers;

use App\Actions\DestroyCheckElement;
use App\Actions\StoreCheckElement;
use App\Actions\UpdateCheckedCheckElement;
use Illuminate\Http\Request;

class CheckElementController extends Controller
{
    public function store(Request $request, StoreCheckElement $action)
    {
        $action->execute($request->all());
        return redirect()->route('lists.show', ['list' => $request->check_list_id]);
        //TODO проверить при пустом значении title
    }

    public function updateChecked(Request $request, UpdateCheckedCheckElement $action)
    {
        $action->execute($request->all(), $request->get("id"));
    }

    public function destroy($id, DestroyCheckElement $action)
    {
        $checkElement = $action->execute($id);
        return redirect()->route('lists.show', ['list' => $checkElement->check_list_id]); //TODO поменять list на checkList
    }
}
