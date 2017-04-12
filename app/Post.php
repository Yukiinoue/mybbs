<?php

namespace App;

use \LaravelArdent\Ardent\Ardent;

class Post extends Ardent
{
    public static $rules = [
        'name' => 'required',
        'body' => 'required',
        'password' => 'required|between: 4-32',
        'posted_at' => 'required',
    ];

    public function files()
    {
        return $this->hasMany('App\File');
    }


}
