<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * タグモデル
 * @package App
 */
class Tag extends Model
{
    protected $fillable = ['name'];

    public function posts()
    {
        return $this->belongsToMany('App\Post');
    }
}
