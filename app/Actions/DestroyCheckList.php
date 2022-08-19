<?php

namespace App\Actions;

use App\Models\CheckList;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;
use App\Http\Controllers\CheckListController;

class DestroyCheckList extends Action
{
    public function execute($id)
    {
        $checkList = Auth::user()->checkLists()->find($id);
        if(!$checkList) {
            $this->failed = true;
            $this->message = "Check list not found";
            return null;
        }
        $checkList->delete();
    }
}