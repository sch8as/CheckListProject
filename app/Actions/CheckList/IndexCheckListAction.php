<?php

namespace App\Actions\CheckList;

use App\Actions\Action;
use Illuminate\Support\Facades\Auth;

class IndexCheckListAction extends Action
{
    public function execute()
    {
        return Auth::user()->checkLists()->orderBy('title')->get();
    }
}