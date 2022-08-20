<?php

namespace App\Actions;

use App\Models\CheckElement;
use Illuminate\Support\Facades\Auth;
//TODO почистить use

class StoreCheckElement extends Action
{
    public function execute(array $data)
    {
        //TODO подумать, как не вызывать эту модель
        $this->CheckModel(Auth::user()->checkLists()->find($data['check_list_id'])); //TODO разобраться с findOr
        return CheckElement::create($data);
    }
}