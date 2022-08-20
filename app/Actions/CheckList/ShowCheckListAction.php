<?php

namespace App\Actions\CheckList;

use App\Actions\Action;
use Illuminate\Support\Facades\Auth;

class ShowCheckListAction extends Action
{
    protected $checkElements;

    public function execute($id)
    {
        $checkList = Auth::user()->checkLists()->find($id);
        $this->CheckModel($checkList);
        $this->checkElements = $checkList->checkElements()->get();
        return $checkList;
    }

    public function getCheckElements()
    {
        return $this->checkElements;
    }
}