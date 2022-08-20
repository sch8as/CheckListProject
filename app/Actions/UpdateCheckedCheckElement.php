<?php

namespace App\Actions;

use Illuminate\Support\Facades\Auth;
//TODO почистить use

class UpdateCheckedCheckElement extends Action
{
    public function execute(array $data, $id)
    {
        $checked = $data['checked'];
        $checkElement = Auth::user()->checkElements()->find($id);
        $this->CheckModel($checkElement);
        $checkElement->checked=$checked; //TODO Изменить на fill
        $checkElement->save();
        return $checkElement;
    }
}