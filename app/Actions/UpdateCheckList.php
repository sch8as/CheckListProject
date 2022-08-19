<?php

namespace App\Actions;

use App\Models\CheckList;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;
use App\Http\Controllers\CheckListController;

class UpdateCheckList extends Action
{
    public function execute(array $data, $id)
    {
        $checkList = Auth::user()->checkLists()->find($id); //TODO Переделать в findOr
        if(!$checkList) {
            $this->failed = true;
            $this->message = "Check list not found";
            return null;
        }

        $checkList->update($data);
        return $checkList; //TODO добавить сообщение и при success
    }
}