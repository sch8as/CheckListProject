<?php

namespace App\Http\Controllers;

use App\Models\CheckElement;
use App\Models\CheckList;
use Illuminate\Http\Request;

class CheckElementController extends Controller
{
    public function index($id)
    {
        $checkList = CheckList::find($id);
        $checkList->check_current_user_is_owner();
        $checkElements = CheckElement::where('check_list_id', '=', $id)->orderBy('title')->get();
        return view('check_element/index', compact('checkList', 'checkElements'));
    }

    public function store(CheckElement $checkElementModel, Request $request)
    {

        $checkList = CheckList::find($request->check_list_id);
        $checkList->check_current_user_is_owner();

        $checkElementModel->create($request->all());
        return redirect()->to('elements/'.$request->check_list_id);
    }

    public function update_checked(Request $request)
    {
        $id = $request->get('id');
        $checked = $request->get('checked');

        $element=CheckElement::find($id);
        $element->check_current_user_is_owner();
        $element->checked=$checked;
        $element->save();
    }

    public function destroy($id)
    {
        $element = CheckElement::find($id);
        $element->check_current_user_is_owner();
        $check_list_id = $element->check_list_id;
        $element->delete();
        return redirect()->to('elements/'.$check_list_id);
    }
}
