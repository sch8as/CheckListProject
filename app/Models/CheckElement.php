<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckElement extends Model
{
    use HasFactory;

    protected $fillable = ['title','check_list_id'];

    public function checkList()
    {
        return $this->belongsTo('App\Models\CheckList');
    }
}
