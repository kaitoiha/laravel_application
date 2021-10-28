<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillale = ["title","body"];
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
