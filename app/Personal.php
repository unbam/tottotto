<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * 個人設定モデル
 * @package App
 */
class Personal extends Model
{
    protected $fillable = ['lang', 'view', 'per_page', 'theme'];

    /**
     * リレーション(ユーザー)
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
