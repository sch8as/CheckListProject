<?php

namespace App\Actions\CheckList;

use App\Actions\Action;
use Illuminate\Support\Facades\Auth;

class DestroyCheckListAction extends Action
{
    public function execute($id)
    {
        $checkList = Auth::user()->checkLists()->find($id);
        $this->checkModel($checkList);
        $checkList->delete();
        return $checkList;
    }
}