<?php

namespace App\Actions;

use App\Models\CheckList;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;

class IndexCheckList extends Action
{
    public function execute()
    {
        return Auth::user()->checkLists()->orderBy('title')->get();
    }
}