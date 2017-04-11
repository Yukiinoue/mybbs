<?php

namespace App;

use Illuminate\Database\Ardent\Ardent;

class File extends Ardent
{
    public static $rules = [
        'post_id' => 'required',
        'contents' => 'required',
    ];

    public function post()
    {
        return $this->belongsTo('App\Post');
    }
}
