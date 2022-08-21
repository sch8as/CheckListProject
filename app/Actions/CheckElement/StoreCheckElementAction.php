<?php

namespace App\Actions\CheckElement;

use App\Actions\Action;
use App\Models\CheckElement;
use Illuminate\Support\Facades\Auth;

class StoreCheckElementAction extends Action
{
    public function execute(array $data)
    {
        $this->checkModel(Auth::user()->checkLists()->find($data['check_list_id']));
        return CheckElement::create($data);
    }
}