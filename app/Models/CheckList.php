<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class CheckList extends Model
{
    use HasFactory;

    protected $fillable = ['title','description', 'user_id'];

    public function check_current_user_is_owner()
    {
        $this->check_user_is_owner(Auth::id());
    }

    public function check_user_is_owner($user_id)
    {
        if($this->user_id != $user_id)
            abort(403);
    }
}
