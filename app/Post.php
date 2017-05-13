<?php

namespace App;

// use \LaravelArdent\Ardent\Ardent;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    /**
     * モデルと関連しているテーブルの指定
     *
     * @var string
     */
    protected $table = 'posts';

    /**
     * createメソッド実行時に、入力を禁止するカラムの指定
     *
     * @var array
     */
    protected $guarded = array('id');

    // Ardentでバリデーションしたい
    // public static $rules = [
    //     'name' => 'required',
    //     'body' => 'required',
    //     'password' => 'required|between: 4-32',
    //     'posted_at' => 'required',
    // ];

    public function files()
    {
        return $this->hasMany('App\File');
    }


}

