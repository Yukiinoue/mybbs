<?php

namespace App;

// use \LaravelArdent\Ardent\Ardent;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class File extends Model
{

    /**
     * モデルと関連しているテーブルの指定
     *
     * @var string
     */
    protected $table = 'files';

    /**
     * createメソッド実行時に、入力を禁止するカラムの指定
     *
     * @var array
     */
    protected $guarded = array('id');

    public function post()
    {
        return $this->belongsTo('App\Post','post_id', 'id')->orderBy('id', 'desc');
    }
}
