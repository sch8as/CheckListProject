<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckList extends Model
{
    use HasFactory;

    protected $fillable = ['title','description', 'user_id'];

    public function elements()
    {
        return $this->hasMany(CheckElement::class);
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
