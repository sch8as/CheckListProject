<?php

namespace App\Actions;

use Illuminate\Support\Facades\Auth;

class DestroyCheckList extends Action
{
    public function execute($id)
    {
        $checkList = Auth::user()->checkLists()->find($id);
        $this->CheckModel($checkList);
        $checkList->delete();
        return $checkList;
    }
}