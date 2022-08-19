<?php

namespace App\Actions;

use App\Models\CheckList;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;

class ShowCheckList extends Action
{
    protected $checkElements;

    public function execute($id)
    {
        $checkList = Auth::user()->checkLists()->find($id);
        if(!$checkList) {
            $this->failed = true;
            $this->message = "Check list not found";
            return null;
        }

        $this->checkElements = $checkList->checkElements()->get();
        return $checkList;
    }

    public function getCheckElements()
    {
        return $this->checkElements;
    }
}