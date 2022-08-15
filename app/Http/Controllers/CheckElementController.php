<?php

namespace App\Http\Controllers;

use App\Models\CheckElement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckElementController extends Controller
{


    public function store(CheckElement $checkElementModel, Request $request)
    {
        $checkList = Auth::user()->checkLists()->findOrFail($request->check_list_id);

        $checkElementModel->create($request->all());
        return redirect()->route('lists.show', ['list' => $request->check_list_id]);
    }

    public function updateChecked(Request $request)
    {
        $id = $request->get('id');
        $checked = $request->get('checked');

        $element = Auth::user()->checkElements()->findOrFail($id);

        $element->checked=$checked;
        $element->save();
    }

    public function destroy($id)
    {
        $element = Auth::user()->checkElements()->findOrFail($id);

        $checkListId = $element->check_list_id;

        $element->delete();
        return redirect()->route('lists.show', ['list' => $checkListId]);
    }
}
