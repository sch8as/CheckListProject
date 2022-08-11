<?php

namespace App\Http\Controllers;

use App\Models\CheckElement;
use App\Models\CheckList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckElementController extends Controller
{
    public function index($id)
    {
        $checkList = CheckList::where('user_id', '=', Auth::id())->findOrFail($id);
        $checkElements = CheckElement::where('check_list_id', '=', $id)->orderBy('title')->get();
        return view('check_element/index', compact('checkList', 'checkElements'));
    }

    public function store(CheckElement $checkElementModel, Request $request)
    {
        $checkList = CheckList::where('user_id', '=', Auth::id())->findOrFail($request->check_list_id);

        $checkElementModel->create($request->all());
        return redirect()->route('elements.index', ['list_id' => $request->check_list_id]);
    }

    public function updateChecked(Request $request)
    {
        $id = $request->get('id');
        $checked = $request->get('checked');

        $element = CheckElement::whereHas('checkList', function($q){
            $q->where('user_id', '=', Auth::id());
        })->findOrFail($id);

        $element->checked=$checked;
        $element->save();
    }

    public function destroy($id)
    {
        $element = CheckElement::whereHas('checkList', function($q){
            $q->where('user_id', '=', Auth::id());
        })->findOrFail($id);

        $checkListId = $element->check_list_id;

        $element->delete();
        return redirect()->route('elements.index', ['list_id' => $checkListId]);
    }
}
