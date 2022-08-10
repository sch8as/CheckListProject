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
        $checkList->checkCurrentUserIsOwner();
        $checkElements = CheckElement::where('check_list_id', '=', $id)->orderBy('title')->get();
        return view('check_element/index', compact('checkList', 'checkElements'));
    }

    public function store(CheckElement $checkElementModel, Request $request)
    {

        $checkList = CheckList::find($request->check_list_id);
        $checkList->checkCurrentUserIsOwner();

        $checkElementModel->create($request->all());
        return redirect()->to('elements/'.$request->check_list_id);
    }

    public function updateChecked(Request $request)
    {
        $id = $request->get('id');
        $checked = $request->get('checked');

        $element=CheckElement::find($id);
        $element->checkCurrentUserIsOwner();
        $element->checked=$checked;
        $element->save();
    }

    public function destroy($id)
    {
        $element = CheckElement::find($id);
        $element->checkCurrentUserIsOwner();
        $checkListId = $element->check_list_id;
        $element->delete();
        return redirect()->to('elements/'.$checkListId);
    }
}
