<?php

namespace App\Actions\CheckList;

use App\Actions\Action;
use Illuminate\Support\Facades\Auth;

class DestroyCheckListAction extends Action
{
    public function execute($id)
    {
        $checkList = Auth::user()->checkLists()->find($id);
        $this->CheckModel($checkList);
        $checkList->delete();
        return $checkList;
    }
}