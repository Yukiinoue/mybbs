<?php

namespace App;

// use \LaravelArdent\Ardent\Ardent;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

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

    /**
     * マスアサインメントで事前に登録できる項目の宣言
     *
     * @var array
     */
     protected $fillable = ['reply_id','name', 'body', 'password', 'posted_at'];

    /**
     * 日付ミューテーターの指定
     *
     * @var array
     */
     protected $dates = ['posted_at'];

    // ファイルとの関連性
    public function files()
    {
        return $this->hasMany('App\File');
    }

    static function addPost($request, $reply_id)
    {
        $post = Post::create([
            'reply_id' => $reply_id,
            'name' => $request['name'],
            'body' => $request['body'],
            'password' => $request['password'],
            'posted_at' => Carbon::today(),
        ]);
    }
}

