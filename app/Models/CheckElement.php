<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckElement extends Model
{
    use HasFactory;

    protected $fillable = ['title','check_list_id'];

    public function check_current_user_is_owner()
    {
        $checkList = CheckList::find($this->check_list_id);
        $checkList->check_current_user_is_owner();
    }
}
