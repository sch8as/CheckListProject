<?php

namespace App\Actions;

use App\Models\CheckList;
use App\Http\Controllers\CheckListController;
use Illuminate\Support\Facades\Auth;

class StoreCheckList extends Action
{
    protected $limitExceeded = false;
    protected $message = "";

    public function execute(array $data)
    {
        $limit = Auth::user()->checklist_limit;
        $listsCount = Auth::user()->checkLists()->count();

        // TODO Исправить класс политики
        if ((Auth::user()->can('have-unlimited-lists', [CheckListController::class])) && ($listsCount >= $limit)){
            $newCheckList = array_merge($data, ["user_id" => Auth::id()]);
            return CheckList::create($newCheckList);
        }else{
            $this->limitExceeded = true;
            $this->message = "Limit (" . $limit . ") is exceeded. The list cannot be added.";
            return null;
        }
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function limitIsExceeded()
    {
        return $this->limitExceeded;
    }
}