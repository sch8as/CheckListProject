<?php

namespace App\Actions\CheckElement;

use App\Actions\Action;
use Illuminate\Support\Facades\Auth;

class DestroyCheckElementAction extends Action
{
    public function execute($id)
    {
        $checkElement = Auth::user()->checkElements()->find($id);
        $this->checkModel($checkElement);
        $checkElement->delete();
        return $checkElement;
    }
}