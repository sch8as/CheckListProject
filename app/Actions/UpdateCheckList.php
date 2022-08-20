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
        $this->CheckModel($checkList);
        $checkList->update($data);
        return $checkList;
    }
}