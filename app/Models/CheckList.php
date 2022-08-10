<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class CheckList extends Model
{
    use HasFactory;

    protected $fillable = ['title','description', 'user_id'];

    public function checkCurrentUserIsOwner()
    {
        $this->checkUserIsOwner(Auth::id());
    }

    public function checkUserIsOwner($userId)
    {
        if($this->user_id != $userId)
            abort(403);
    }
}
