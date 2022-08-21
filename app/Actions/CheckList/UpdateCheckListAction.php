<?php

namespace App\Actions\CheckList;

use App\Actions\Action;
use Illuminate\Support\Facades\Auth;

class UpdateCheckListAction extends Action
{
    public function execute(array $data, $id)
    {
        $checkList = Auth::user()->checkLists()->find($id);
        $this->checkModel($checkList);
        $checkList->update($data);
        return $checkList;
    }
}