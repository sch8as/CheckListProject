<?php

namespace App\Actions\CheckElement;

use App\Actions\Action;
use Illuminate\Support\Facades\Auth;
//TODO почистить use

class UpdateCheckedCheckElementAction extends Action
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