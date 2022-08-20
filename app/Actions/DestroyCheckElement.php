<?php

namespace App\Actions;

use Illuminate\Support\Facades\Auth;

class DestroyCheckElement extends Action
{
    public function execute($id)
    {
        $checkElement = Auth::user()->checkElements()->find($id);
        $this->CheckModel($checkElement);
        $this->checkListId = $checkElement->check_list_id;
        $checkElement->delete();
        return $checkElement;
    }
}