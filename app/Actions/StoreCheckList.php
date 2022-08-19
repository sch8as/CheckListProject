<?php

namespace App\Actions;

use App\Models\CheckList;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;
use App\Http\Controllers\CheckListController;

class StoreCheckList extends Action
{
    public function execute(array $data)
    {
        $limit = Auth::user()->checklist_limit;
        //dd(Auth::user());
        $listsCount = Auth::user()->checkLists()->count();

        if((!Auth::user()->can('have-unlimited-lists', [CheckListController::class])) && $listsCount >= $limit) {
            $this->failed = true;
            $this->message = "Limit (" . $limit . ") is exceeded. The list cannot be added.";
            //throw new Exception($message);
            //CheckList $checkList;
            return null;
        }

        $currentUserId = ["user_id" => Auth::id()];
        //$currentUserId = ["user_id" => 1];
        $newCheckList = array_merge($data, $currentUserId);
        
        return CheckList::create($newCheckList);
    }
}