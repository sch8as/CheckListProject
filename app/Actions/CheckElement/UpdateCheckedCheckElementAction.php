<?php

namespace App\Actions\CheckElement;

use App\Actions\Action;
use Illuminate\Support\Facades\Auth;

class UpdateCheckedCheckElementAction extends Action
{
    public function execute(array $data, $id)
    {
        $checkElement = Auth::user()->checkElements()->find($id);
        $this->checkModel($checkElement);
        $checkElement->checked = $data['checked'];
        $checkElement->save();
        return $checkElement;
    }
}