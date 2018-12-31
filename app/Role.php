<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * 権限モデル
 * @package App
 */
class Role extends Model
{
    protected $fillable = ['name', 'level'];

    /**
     * リレーション(ユーザー)
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function user()
    {
        return $this->hasMany('App\User');
    }
}
