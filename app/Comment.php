<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * コメントモデル
 * @package App
 */
class Comment extends Model
{
    protected $fillable = ['comment'];

    /**
     * リレーション(投稿)
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function post()
    {
        return $this->belongsTo('App\Post');
    }

    /**
     * リレーション(ユーザー)
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
