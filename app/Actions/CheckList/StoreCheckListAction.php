<?php

namespace App\Actions\CheckList;

use App\Actions\Action;
use App\Models\CheckList;
use App\Http\Controllers\CheckListController;
use Illuminate\Support\Facades\Auth;

class StoreCheckListAction extends Action
{
    protected $limitExceeded = false;
    protected $message = "";

    public function execute(array $data)
    {
        $limit = Auth::user()->checklist_limit;
        $listsCount = Auth::user()->checkLists()->count();

        if ((Auth::user()->can('have-unlimited-lists', [CheckListController::class])) || ($listsCount < $limit)){
            $checkListData = array_merge($data, ["user_id" => Auth::id()]);
            return CheckList::create($checkListData);
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