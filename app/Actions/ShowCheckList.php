<?php

namespace App\Actions;

use Illuminate\Support\Facades\Auth;

class ShowCheckList extends Action
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