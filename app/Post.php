<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

/**
 * 投稿モデル
 * @package App
 */
class Post extends Model
{
    use Sortable;

    protected $fillable = ['posted_at', 'title', 'content', 'is_notifiable'];

    protected $dates = ['posted_at'];

    public $sortable = ['posted_at', 'title', 'status_id', 'category_id'];

    /**
     * リレーション(投稿ステータス)
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function status()
    {
        return $this->belongsTo('App\Status');
    }

    /**
     * リレーション(カテゴリ)
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    /**
     * リレーション(ユーザー)
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * リレーション(タグ)
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany('App\Tag', 'posts_tags');
    }

    /**
     * リレーション(コメント)
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany('App\Comment');
    }
}
