<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $fillable = [
        'post_id','filename','format','mime'
    ];

    public function post()
    {
        return $this->belongsTo('App\Post');
    }
}
